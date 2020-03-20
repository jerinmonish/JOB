<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\JobRepository;
use App\Repositories\UserRepository;
use yajra\Datatables\Datatables;
use App\Helpers\LERHelper;
use App\Events\UserSubscribed;
use App\JobApplied;
use App\User;
use App\JobSubscription;
use Redirect;
use Session;
use File;
use Auth;

class EmployeeController extends Controller
{
	private $jobData;
	private $userData;

    public function __construct(JobRepository $jobData, UserRepository $userData){
        $this->jobData = $jobData;
        $this->userData = $userData;
    }

	public function listAllJobs()
    {
        return view('employee.list-emp-jobs');
    }
    
    public function listAllEmpJobs(){
    	$jobs = $this->jobData->allActiveNotApplied();
        return Datatables::of($jobs)
                        ->addColumn('viewLink', function ($jobs) {
                            $applied = LERHelper::check_job_applied(@$jobs->id,@Auth::user()->id,@$jobs->req_id);
                            if($applied == 1){
                                $applyLinkSet = '<button class="btn btn-info">Applied</button>';
                            } else {
                                $applyLinkSet = '<a href="'. route('apply-job',array(LERHelper::encryptUrl(@$jobs->id))) .'" class="btn btn-warning">Apply</a>';
                            }
                            return '<a href="'. route('view-job',array(LERHelper::encryptUrl(@$jobs->id))) .'" class="btn btn-primary">View</a> '.$applyLinkSet; 
                        })->editColumn('created_at', function ($jobs) {
							return LERHelper::formatDate($jobs->created_at);
						})
						->rawColumns(['viewLink'])
                        ->make(true);
    }

    public function viewJob($id)
    {   
    	$id = LERHelper::decryptUrl($id);
        $this->jobData->jobViews($id);
        if(isset($_GET['nid']) && !empty($_GET['nid'])){
            $this->jobData->markRead($_GET['nid']);
        }
        $job['job'] = $this->jobData->jobBasedIdOnly($id);
        if(isset($job['job']) && !empty($job['job'])){
            $tagHelper = LERHelper::getTagNameMultiple(@$job['job']['job_keywords']);
            $job['job']['job_keywords'] = $tagHelper;
            return view('employee.job-show', $job);
        } else {
            return redirect()->back()->with(['error' => "No such Job Found !"]);
        }
    }

    public function applyJob($id){
        $job_id = LERHelper::decryptUrl($id);
        $job_check = $this->jobData->jobBasedIdOnly($job_id);
        if(!empty($job_check)){

            $applied = LERHelper::check_job_applied(@$job_id,@Auth::user()->id,@$job_check->req_id);
            if($applied == 1){
                return redirect()->back()->with(['error' => "Sorry you have already applied for that job"]);
            } else {
                $data['job_posted_id']  = $job_check->req_id;
                $data['job_id']         = $job_id;
                $data['employee_id']    = @Auth::user()->id;
                $job_applied = new JobApplied($data);
                $return = $job_applied->save();
                if($return){
                    return redirect()->back()->with(['success' => "Applied successfully !"]);
                } else {
                    return redirect()->back()->with(['error' => "Failed to apply due to some issue !"]);
                }
            }
        } else {
            return redirect()->back()->with(['error' => "The job you are applying has been outdated, Hence Fourth you can apply !"]);
        }
    }

    public function listAllAppliedJobs(){
        $jobs = $this->jobData->employeeAppliedJob();
        return Datatables::of($jobs)
                        ->addColumn('viewLink', function ($jobs) {
                            return '<a title="View InDetail" href="'. route('detail-applied-job',array(LERHelper::encryptUrl(@$jobs->job_applied_id))) .'" class="btn btn-primary"><i class="fa fa-eye"></i></a> '; 
                        })->editColumn('created_at', function ($jobs) {
                            return LERHelper::formatDate($jobs->created_at);
                        })->editColumn('ja_created_at', function ($jobs) {
                            return LERHelper::formatDate($jobs->ja_created_at);
                        })
                        ->rawColumns(['viewLink'])
                        ->make(true);
    }

    public function appliedJob(){
        return view('employee.list-applied-jobs');
    }

    public function appliedjobIndetail($jobapplied_id){
        $applied_id = LERHelper::decryptUrl($jobapplied_id);
        $user_id = @Auth::user()->id;
        $data['check_criteria'] = JobApplied::where('id', $applied_id)->where('employee_id', $user_id)->where('status', 'Active')->first();
        if(!empty($data['check_criteria']->id)){
            $data['job'] = $this->jobData->jobBasedIdOnly($data['check_criteria']->job_id);
            $data['req'] = $this->userData->findById($data['check_criteria']->job_posted_id);
            return view('employee.show-jobapplied-detail',$data);
        } else {
            return redirect()->back()->with(['error' => "User Mismatch or Job Inactive"]);
        }
    }

    public function subscribeJob(Request $request){
        $response=array(
            'status' => false,
            'message' => "Invalid Request",
            'data' => false
        );
        $data = $request->all();
        if(!empty($data['employer_id'])){
            $save['employer_id'] = LERHelper::decryptUrl($data['employer_id']);
            $save['employee_id'] = @Auth::user()->id;
            $save['interested_by'] = "Employee";
            $verify = JobSubscription::where('employer_id', $save['employer_id'])->where('employee_id', $save['employee_id'])->where('status', 'Active')->first();
            if(!empty($verify['id'])){
                 $response['status'] = 3;
            } else {
                $subscribe = new JobSubscription($save);
                $return = $subscribe->save();
                if($return){
                    
                    /*Send notifications that user subscribed to you starts*/
                    $notify_data['from_id'] = ($save['interested_by'] == 'Employee') ? $save['employee_id']: $save['employer_id']; //set dynamic id based on interest of user
                    $notify_data['to_id'] = ($save['interested_by'] == 'Employee') ? $save['employer_id']: $save['employee_id']; //set dynamic id based on interest of user
                    $notify_data['id_redirect'] = $subscribe['id'];
                    $notify_data['subject'] = ($save['interested_by'] == 'Employee') ? '<b>'.LERHelper::getFullName($save['employee_id']).'</b> has Subscribed to your job': '<b>'.LERHelper::getFullName($save['employer_id']).'</b> has just subscribe to you'; //set dynamic id based on interest of user
                    $notify_data['notification_type'] = 'User Subscribed';
                    $add_notify = $this->jobData->saveNotificationsCommon($notify_data);
                    if($add_notify['status'] == 1){
                        $subscribe->setNotify = $notify_data['subject'];
                        event(new UserSubscribed($subscribe)); //To show a notification that a new job has been created
                    }
                    /*Send notifications that user subscribed to you ends*/
                    
                    $response = array(
                                    'del_id'=>LERHelper::encryptUrl(@$subscribe['id']),
                                    'status'=>'1'
                                );
                } else {
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 2;
        }

        return response()->json($response);
    }

    public function unsubscribeJob(Request $request){
        $response=array(
            'status' => false,
            'message' => "Invalid Request",
            'data' => false
        );
        $data = $request->all();
        $id = LERHelper::decryptUrl($data['id']);
        $job  = JobSubscription::find($id);
        /*Send notifications that user subscribed to you starts*/
            $notify_data['from_id'] = @Auth::user()->id;
            $notify_data['to_id']   = $job['employer_id'];
            $notify_data['id_redirect'] = $job['id'];
            $notify_data['subject'] = '<b>'.LERHelper::getFullName(@Auth::user()->id).'</b> has unsubscribed from You'; //set dynamic id based on interest of user
            $notify_data['notification_type'] = 'User Unsubscribed';
            $add_notify = $this->jobData->saveNotificationsCommon($notify_data);
            if($add_notify['status'] == 1){
            $job->setNotify = $notify_data['subject'];
            event(new UserSubscribed($job)); //To show a notification that a new job has been created
            }
        /*Send notifications that user subscribed to you ends*/
        $deleted = $job->delete();
        if($deleted){
            $response['status'] = 4;
        }else {
            $response['status'] = 0;
        }
        return response()->json($response);
    }

    public function ViewSubscribedEmployer(){
        return view('employee.list-subscribed-employer');
    }

    public function listAllSubscribedEmployer(){
        $subscribed = JobSubscription::where('status', 'Active')->where('employee_id', @Auth::user()->id)->get();
        return Datatables::of($subscribed)
                        ->addColumn('viewLink', function ($subscribed) {
                            return '<a title="View All Jobs from this employer" href="'. route('employer-jobs',array(LERHelper::encryptUrl(@$subscribed->employer_id))) .'" class="btn btn-success">View All jobs</a>
                                    <a title="Unsubscribe Employer" href="#" class="btn btn-danger subscribeunsubscribe" id="subscribeunsubscribe" data-eid="'.LERHelper::encryptUrl($subscribed->id).'">Unsubscribe</a>'; 
                        })->editColumn('created_at', function ($subscribed) {
                            return LERHelper::formatDate($subscribed->created_at);
                        })->editColumn('employer_id', function ($subscribed) {
                            return LERHelper::getFullName($subscribed->employer_id);
                        })
                        ->rawColumns(['viewLink'])
                        ->make(true);
    }


    public function demodd(){
        $article = \App\JobApplied::with(['belongsUser','belongsJob'])->first();
        $categories = \App\User::with('employerPostedJob')->get();
        $users = \App\User::with('employerPostedJob')->get();
        foreach ($users as $key => $value) {
            echo '<pre>';print_r($value);
        }exit;
        dd($users);
    }
    
}
