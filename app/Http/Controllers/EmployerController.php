<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\JobRepository;
use yajra\Datatables\Datatables;
use App\Helpers\LERHelper;
use App\JobSubscription;
use DB;
use Auth;
class EmployerController extends Controller
{

    private $userData;
	private $jobData;

	public function __construct(UserRepository $userData, JobRepository $jobData){
        $this->jobData = $jobData;
		$this->userData = $userData;
	}
    //view page for active users
    public function listActiveEmployee(){
    	return view('employer.list-users');
    }

    //list only active users
    public function listAllActiveUsers(){
    	$users = $this->userData->onlyActiveEmployee();
        return Datatables::of($users)
                        ->addColumn('viewLink', function ($users) {
                            return '<a title="View User" href="'. route('view-iuser',array(LERHelper::encryptUrl(@$users->id))) .'" class="btn btn-primary"><i class="fa fa-eye"></i></a>'; 
                        })
                        ->rawColumns(['viewLink'])
                        ->make(true);
    }

    //view page for applied candidates
    public function appliedCandidate(){
        return view('employer.list-candidate-applied');
    }

    //list of applied candidates
    public function listallCandidatesappliedtomyjob(){
        $jobs = $this->jobData->appliedEmployeeJob();
        return Datatables::of($jobs)
                        ->addColumn('viewLink', function ($jobs) {
                            return '<a title="View InDetail" href="'. route('job-applied-candidate',array(LERHelper::encryptUrl(@$jobs->job_applied_id))) .'" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    <a title="Message User" href="'. route('chat.show',array(LERHelper::encryptUrl(@$jobs->applicant_id))) .'?jid='.LERHelper::encryptUrl(@$jobs->j_id).'" class="btn btn-success"><i class="fa fa-comments-o"></i></a>
                                    <a title="Delete" href="'. route('detail-applied-job',array(LERHelper::encryptUrl(@$jobs->job_applied_id))) .'" class="btn btn-danger"><i class="fa fa-trash"></i></a> '; 
                        })->editColumn('created_at', function ($jobs) {
                            return LERHelper::formatDate($jobs->created_at);
                        })->editColumn('ja_created_at', function ($jobs) {
                            return LERHelper::formatDate($jobs->ja_created_at);
                        })->editColumn('first_name', function ($jobs) {
                            return $jobs->first_name.' '.$jobs->last_name;
                        })
                        ->rawColumns(['viewLink'])
                        ->make(true);
    }

    //To view in detail about applied candidates based on id
    public function viewCandiateApplied($id){
        $id = LERHelper::decryptUrl($id);
        $jobApplied = DB::statement('UPDATE job_applied SET employer_seen = "Seen" where id = '.$id);
        $data['job_applied'] = $this->jobData->jobAppliedBasedIdOnly($id);
        if($data['job_applied']){
            $data['job_data'] = $this->jobData->jobBasedIdOnly($data['job_applied']->job_id);
            $data['employee_data'] = $this->userData->findById($data['job_applied']->employee_id);
            return view('employer.candidate-applied-detail',$data);
        } else {
            return redirect()->route('applied-candidate')->with('danger','No such Record');
        }
    }

    public function ViewSubscribedEmployee(){
        return view('employer.list-subscribed-employee');
    }

    public function listAllSubscribedEmployee(){
        $subscribed = JobSubscription::where('status', 'Active')->where('employer_id', @Auth::user()->id)->get();
        return Datatables::of($subscribed)
                        ->addColumn('viewLink', function ($jobs) {
                            return '<a title="View Profile" href="'.route('view-iuser',array(LERHelper::encryptUrl(@$jobs->employee_id))).'" class="btn btn-primary"><i class="fa fa-eye"></i></a>'; 
                        })
                        ->editColumn('created_at', function ($subscribed) {
                            return LERHelper::formatDate($subscribed->created_at);
                        })->editColumn('employee_id', function ($subscribed) {
                            return LERHelper::getFullName($subscribed->employee_id);
                        })
                        ->rawColumns(['viewLink'])
                        ->make(true);
    }

}
