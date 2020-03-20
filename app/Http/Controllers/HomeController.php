<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Repositories\UserRepository;
use App\Repositories\JobRepository;
use yajra\Datatables\Datatables;
use App\Helpers\LERHelper;
use App\User;
use App\Job;
use App\Country;
use App\State;
use Redirect;
use Session;
use File;
use Auth;
use Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userrep, JobRepository $jobRep)
    {
        $this->middleware('auth');
        $this->userrep = $userrep;
        $this->jobRep = $jobRep;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user['user'] = $this->userrep->findById(@Auth::user()->id);
        $user['country'] = Country::all('country_name', 'id');
        $user['state']   = !empty(@Auth::user()->state) ? State::find(@Auth::user()->state) : [] ;
        return view('profile-update', $user);
    }

    public function profileUpdate(ProfileUpdateRequest $request){
        $user  = User::find(@Auth::user()->id);
        $data = $request->all();
        //img upload for update
        if(!empty($request->file('resume_doc'))){
            $resumeDelete = isset($user['resume_doc']) ? $user['resume_doc'] : '';
            if(!empty($resumeDelete)){                
                if(\File::exists(public_path('/assets/user/resume/'.$resumeDelete))){
                  \File::delete(public_path('/assets/user/resume/'.$resumeDelete));
                }
            }

            $fileName = @Auth::user()->first_name.'-'.@Auth::user()->last_name.date('y-m-d').'.'.$request->resume_doc->extension();  
   
            $request->resume_doc->move(public_path('/assets/user/resume/'), $fileName);
            $data['resume_doc'] = $fileName;
        }
        if(!empty($request->file('profile_pic'))){
            $profilePicDelete = isset($user['profile_pic']) ? $user['profile_pic'] : '';
            if(!empty($profilePicDelete)){                
                if(\File::exists(public_path('/assets/user/profile_pic/'.$profilePicDelete))){
                  \File::delete(public_path('/assets/user/profile_pic/'.$profilePicDelete));
                }
            }
            $picName = @Auth::user()->first_name.'-'.@Auth::user()->last_name.date('y-m-d').'.'.$request->profile_pic->extension();  
            $request->profile_pic->move(public_path('/assets/user/profile_pic/'), $picName);
            $data['profile_pic'] = $picName;
        }
         if ($user->update($data)) {
            return redirect()->route('profile')->with('success','Profile Successfully Updated');
        } else {
            return redirect()->route('profile')->with('danger','Failed to update Profile');
        }
    }

    public function changePassword(){
        return view('change-password');
    }

    public function passwordUpdate(ChangePasswordRequest $request){
        $userData = User::findorfail(@Auth::user()->id);
        $input  = $request->all();
        $user['password'] = bcrypt($input['new_password']);
        if(!Hash::check($input['existing_password'], $userData['password'])){
             return Redirect::back()->with('error', trans('The specified old password does not match current password'));
        }else{
            
             $userData->fill($user);
             $userData->save();
             return Redirect::back()->with('success', 'Password Updated Successfully');  
        }
    }

    //list page for all jobs by specific employer
    public function listAllEmployerJobs($id){
        $data['id'] = LERHelper::decryptUrl(@$id);
        return view('common.list-employers-job',$data);
    }

    //redirect to view page for listing job
    public function listAllEmployerJobsView($id){
        $id = LERHelper::decryptUrl(@$id);
        $jobs = Job::where('req_id','=',$id)->get();
        return Datatables::of($jobs)
                    ->addColumn('viewLink', function ($jobs) {
                        $urlJobView = '';
                        if(Auth::user()->role == "admin"){
                            $urlJobView = route('view-ijob',array(LERHelper::encryptUrl(@$jobs->id)));
                        } else if(Auth::user()->role == "employee"){
                            $urlJobView = route('view-job',array(LERHelper::encryptUrl(@$jobs->id)));
                        } else {
                            $urlJobView = '#';
                        }
                        return '<a title="View InDetail" href="'.$urlJobView.'" class="btn btn-primary"><i class="fa fa-eye"></i></a> '; 
                    })->editColumn('created_at', function ($jobs) {
                        return LERHelper::formatDate($jobs->created_at);
                    })->editColumn('job_creator', function ($jobs) {
                        return LERHelper::getFullName($jobs->req_id);
                    })
                    ->rawColumns(['viewLink'])
                    ->make(true);
        return redirect()->back()->with(['error' => "Job details missing"]);   
    }

    public function notificationRead(Request $request){   
        $response = array(
                        'status'=>0,
                        'message'=>'error'
                    );
        $data = $request->all();
        $id   = $data['id'];
        $status = $this->jobRep->markRead($id);
        if($status){
            $response = array(
                        'status'=>1,
                        'message'=>'success'
                    );
        }
        return json_encode($response);
    }

    public function get_state_base_id(Request $request){
        $response = array(
                        'status'=>0,
                        'message'=>'error'
                    );
        $data = $request->all();
        $id   = $data['country_id'];
        $state_data = State::where('country_id',$id)->get();
        if($state_data){
            $response = array(
                        'status'=>1,
                        'message'=>'success',
                        'data'=>$state_data
                    );
        }
        return json_encode($response);
    }

}
