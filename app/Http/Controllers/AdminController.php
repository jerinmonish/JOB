<?php

namespace App\Http\Controllers;
use App\User;
use App\Job;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;
use App\Helpers\LERHelper;
use Auth;
use DB;
class AdminController extends Controller
{

	//redirect to view page for listing user
	public function listSiteUsers(){
    	return view('admin.list-users');
    }
    //listing all user
    public function listAllUsers(){
    	$users = User::all();
    	return Datatables::of($users)
                        ->addColumn('viewLink', function ($users) {
                        	if($users->id == @Auth::user()->id){
                        		$otherLink = '';
                        	} else {
                        		$otherLink = '<a title="Edit User" href="#" class="btn btn-success"><i class="fa fa-comments-o"></i></a>';
                                if(@$users['user_status'] == "Active"){
                                    $otherLink .=' <a title="Make this user as Active" href="'. route('change-user-status',array('status'=>LERHelper::encryptUrl(2),'id'=>LERHelper::encryptUrl(@$users->id))) .'" class="btn btn-danger">Make Inactive</a>';
                                } else {
                                    $otherLink .=' <a title="Make this user as Inactive" href="'. route('change-user-status',array('status'=>LERHelper::encryptUrl(1),'id'=>LERHelper::encryptUrl(@$users->id))) .'" class="btn btn-primary">Make Active</a>';

                                }
                        	}
                            return '<a title="View InDetail" href="'. route('view-iuser',array(LERHelper::encryptUrl(@$users->id))) .'" class="btn btn-primary"><i class="fa fa-eye"></i></a> '.$otherLink; 
                        })->editColumn('created_at', function ($users) {
                            return LERHelper::formatDate($users->created_at);
                        })->editColumn('role', function ($users) {
                            return ucfirst($users->role);
                        })->editColumn('full_name', function ($users) {
                            return ucfirst($users->first_name).' '.$users->last_name;
                        })
                        ->rawColumns(['viewLink'])
                        ->make(true);
    }

    //redirect to view page for listing job
	public function listAdminJobs(){
    	return view('admin.list-jobs');
    }
    //listing all jobs
    public function listAllJobs(){
    	$jobs = Job::all();
    	return Datatables::of($jobs)
                        ->addColumn('viewLink', function ($jobs) {
                            return '<a title="View InDetail" href="'. route('view-ijob',array(LERHelper::encryptUrl(@$jobs->id))) .'" class="btn btn-primary"><i class="fa fa-eye"></i></a> '; 
                        })->editColumn('created_at', function ($jobs) {
                            return LERHelper::formatDate($jobs->created_at);
                        })
                        ->rawColumns(['viewLink'])
                        ->make(true);
    }

    //View user in detail
    public function userInDetail($id){
        if($id){
            $id = LERHelper::decryptUrl(@$id);
            $data['user'] = User::find($id);
            return view('admin.user-details',$data);
        } else {
            return redirect()->back()->with(['error' => "User details missing"]);
        }
    }

    //View user in detail
    public function changeUserStatus($status,$id){
        if($id){
            $id = LERHelper::decryptUrl(@$id);
            $status = LERHelper::decryptUrl(@$status);
            $data['user'] = User::find($id);
            if($status == '1'){ // Make active
                $update = DB::statement('UPDATE users SET user_status = "Active" where id = '.$id);
            } else if($status == '2'){ // Make inactive
                $update = DB::statement('UPDATE users SET user_status = "Inactive" where id = '.$id);
            }
            if($update){
                return redirect()->back()->with(['success' => "User updated successfully"]);    
            } else {
                return redirect()->back()->with(['error' => "Failed to update user"]);
            }
        } else {
            return redirect()->back()->with(['error' => "User details missing"]);
        }
    }

    //View job in detail
    public function jobInDetail($id){
        if($id){
            $id = LERHelper::decryptUrl(@$id);
            $data['job'] = Job::find($id);
            $data['posted'] = User::find($data['job']->req_id);
            return view('admin.job-indetail',$data);
        } else {
            return redirect()->back()->with(['error' => "Job details missing"]);   
        }
    }
}
