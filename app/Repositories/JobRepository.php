<?php

namespace App\Repositories;
use App\Job;
use App\JobApplied;
use App\JobSubscription;
use App\User;
use App\Notification;
use App\JobView;
use App\Helpers\LERHelper;
use Auth;
use DB;
class JobRepository
{
	public function all(){
		return Job::orderBy('id','desc')->get();
    					/*->map(function($user){
    						return $user->format($user);
    					});*/
	}

    public function allActive(){
        return Job::orderBy('id','desc')->where('status','Active')->get();
    }

    public function allActiveNotApplied(){
        $query = DB::table('job')
                    ->whereNotIn('id', function($query){
                        $query->select(DB::raw('job_id'))
                        ->from('job_applied')
                        ->whereRaw('job_applied.employee_id = '.@Auth::user()->id);
                    })->get();
        return $query;
        //return Job::orderBy('id','desc')->where('status','Active')->get();
    }

    //To get only job based on id and creator id
	public function jobBasedId($id,$r_id){
		return Job::orderBy('id','desc')
    					->where('status','Active')
                        ->where('id',$id)
    					->where('req_id','=',$r_id)
    					->first();
	}

     //To get only job based on id and creator id
    public function jobBasedIdOnly($id){
        return Job::orderBy('id','desc')
                        ->where('status','Active')
                        ->where('id',$id)
                        ->first();
    }

    //To get applied job - For Employee
    public function employeeAppliedJob(){
        $query = DB::table('job')
                        ->join('job_applied', 'job.id', '=', 'job_applied.job_id')
                        ->where('job_applied.employee_id','=',@Auth::user()->id)
                        ->where('job_applied.status','Active')
                        ->select('job.id as j_id', 'job.job_title', 'job.phone_no', 'job.created_at', 'job.req_email','job_applied.created_at as ja_created_at','job_applied.id as job_applied_id')
                        ->get();
        return $query;
        //return Job::orderBy('id','desc')->where('status','Active')->get();
    }

    //To get applied candiate - For Employer
    public function appliedEmployeeJob(){
        $query = DB::table('job')
                        ->join('job_applied', 'job.id', '=', 'job_applied.job_id')
                        ->join('users', 'users.id', '=', 'job_applied.employee_id')
                        ->where('job_applied.job_posted_id','=',@Auth::user()->id)
                        ->where('job_applied.status','Active')
                        ->select('job.id as j_id', 'job.job_title', 'job.created_at', 'job.req_email','job_applied.created_at as ja_created_at','job_applied.id as job_applied_id','users.first_name','users.last_name','users.email','users.mobile_no','users.id as applicant_id')
                        ->get();
        return $query;
        //return Job::orderBy('id','desc')->where('status','Active')->get();
    }

    //To get only job applied based on id
    public function jobAppliedBasedIdOnly($id){
        return JobApplied::where('status','Active')
                        ->where('id',$id)
                        ->first();
    }

    //To get only employers jobs
	public function getEmployerJobs($r_id){
		return User::find($r_id)->employerPostedJob;
                        /*Job::orderBy('id','desc')
                        ->where('status','Active')
                        ->where('req_id','=',$r_id)
                        ->get();*/
	}

    public function whileJobCreate($job_data){
        $response=array(
            'status' => 0,
            'message' => "No",
            'data' => false
        );
        $getSubscribed = JobSubscription::where('employer_id',$job_data['req_id'])->get();
        $status = 0;
        if(!empty($getSubscribed) && count($getSubscribed) > 0){
            foreach ($getSubscribed as $subkey => $subvalue) {
                $data['from_id']           = $job_data['req_id'];
                $data['to_id']             = $subvalue->employee_id;
                $data['id_redirect']       = $job_data['job_id'];
                $data['subject']           = 'New Job ('.$job_data['job_title'].') Posted By <b>'.LERHelper::getFullName($job_data['req_id']).'</b>';
                $data['notification_type'] = 'Job Posted';
                $notify = new Notification($data);
                $saved = $notify->save();
                if($saved){
                    $data['notify_id'] = @$notify->id;
                    $response['status']  = 1;
                    $response['data']    = $data;
                    $response['message'] = "Success";
                }
            }
        }
        return $response;
    }

    //To make read status for all the notifications
    public function markRead($id){
        $id = LERHelper::decryptUrl($id);
        $noti  = Notification::find($id);
        if($noti){
            $data['read_status'] = 'Read';
            $data['read_at']     = date('Y-m-d h:i:s');
            $notify = $noti->update($data);
            return $notify;
        } else {
            return false;
        }
    }

    //To Save notifications common for all
    public function saveNotificationsCommon($set){
        $response=array(
            'status' => 0,
            'message' => "No",
            'data' => false
        );
        $data['from_id']               = $set['from_id'];
        $data['to_id']                 = $set['to_id'];
        $data['id_redirect']           = $set['id_redirect'];
        $data['subject']               = $set['subject'];
        $data['notification_type']     = $set['notification_type'];
        $data['notification_type_val'] = @$set['notification_type_val'];
        $notify = new Notification($data);
        $saved = $notify->save();
        if($saved){
            $response['notify_id'] = @$notify->id;
            $response['status']    = 1;
            $response['message']   = 'Success';
        }
        return $response;
    }

    //To make views on job only for employees
    public function jobViews($j_id){
        if(Auth::user()->role == 'employee'){
            $user = JobView::where('viewer_id',Auth::user()->id)
                                        ->where('job_id',$j_id)
                                        ->get();
                $data['job_id']     = $j_id;
                $data['viewer_id']  = Auth::user()->id;
                $data['viewer_ip']  = \Request::ip();
                $viewObj = new JobView($data);
            if(($user->count() > 0 && date('Y-m-d') == date('Y-m-d',strtotime($user[0]['created_at'])))){
                $viewObj->update($data);
            } else {
                $viewObj->save($data);
            }
        }
    }
}

?>