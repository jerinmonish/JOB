<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Repositories\JobRepository;
use yajra\Datatables\Datatables;
use App\Helpers\LERHelper;
use App\Events\JobSubmitted;
use App\Job;
use App\JobTags;
use Redirect;
use Session;
use File;
use Auth;

class JobController extends Controller
{

    private $jobData;

    public function __construct(JobRepository $jobData){
        $this->jobData = $jobData;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $users = $this->jobData->getEmployerJobs(@Auth::user()->id);
        return view('employer.job.list-jobs');
    }
    public function listAllActivejobs()
    {
        $jobs = $this->jobData->getEmployerJobs(@Auth::user()->id);
        
        return Datatables::of($jobs)
                        ->addColumn('editLink', function ($jobs) {
                            return '<a href="'. route('job.show',array(LERHelper::encryptUrl(@$jobs->id))) .'" class="btn btn-primary">View</a>
                            <a href="'. route('job.edit',array(LERHelper::encryptUrl(@$jobs->id))) .'" class="btn btn-warning">Edit</a>
                            <a href="'. route('job.delete',array(LERHelper::encryptUrl(@$jobs->id))) .'" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this item ?\')">Delete</a>'; 
                        })
                        ->rawColumns(['editLink'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags['tag_data'] = JobTags::where('user_status','Active')->get();
        return view('employer.job.create',$tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        $data = $request->all();
        $jdupload = '';
        if(!empty($request->file('jd_desc'))){
            $jdupload = LERHelper::set_uploads($request,$request->file('jd_desc')->getClientOriginalName(),'/assets/job/jd/');
        }
        $impTag = implode(",", $data['job_keywords']);
        $data['job_keywords'] = $impTag;
        $data['req_id']  = @Auth::user()->id;
        $data['jd_desc'] = $jdupload;
        $job = new Job($data);
        $job->save();
        $data['job_id'] = @$job->id;
        $add_notify = $this->jobData->whileJobCreate($data);
        if($add_notify['status'] == 1){
            $job->setNotify    = '<a class="dropdown-item" href="'.route('view-job',array(LERHelper::encryptUrl(@$data['job_id']))).'">'.$add_notify['data']['subject'].'</a>';
            $job->setNotifyId  = $add_notify['data']['id_redirect'];
            event(new JobSubmitted($job)); //To show a notification that a new job has been created
        }
        return redirect()->route('job.index')->with('success','Created a new job');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = LERHelper::decryptUrl($id);
        $job['job'] = $this->jobData->jobBasedId($id,@Auth::user()->id);
        $tagHelper = LERHelper::getTagNameMultiple(@$job['job']['job_keywords']);
        $job['job']['job_keywords'] = $tagHelper;
        return view('employer.job.show', $job);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = LERHelper::decryptUrl($id);
        $job['job'] = $this->jobData->jobBasedId($id,@Auth::user()->id);
        $job['tag_data'] = JobTags::where('user_status','Active')->get();
        return view('employer.job.edit', $job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, $id)
    {
        $job  = Job::find($id);
        $data = $request->all();
        //img upload for update
        if(!empty($request->file('jd_desc'))){
            $jdupload = LERHelper::set_uploads($request,$request->file('jd_desc')->getClientOriginalName(),'/assets/job/jd/',$data['existing_jd_desc']);
            $data['jd_desc'] = $jdupload;
        }
        $impTag = implode(",", $data['job_keywords']);
        $data['job_keywords'] = $impTag;
         if ($job->update($data)) {
            return redirect()->route('job.index')->with('success','Job Successfully Updated');
        } else {
            return redirect()->route('job.index')->with('danger','Failed to update Job');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = LERHelper::decryptUrl($id);
        $job  = Job::findOrFail($id);
        if($job){
            $job->delete();
            return redirect()->route('job.index')->with('success','Job Successfully Deleted');
        } else {
            return redirect()->route('job.index')->with('danger','No Such Job Found !');
        }
    }
}
