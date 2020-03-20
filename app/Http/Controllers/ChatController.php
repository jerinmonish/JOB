<?php

namespace App\Http\Controllers;

use App\Helpers\LERHelper;
use App\Events\ChatPosted;
use App\Events\UserTypingChat;
use App\Repositories\JobRepository;
use Illuminate\Http\Request;
use App\Chat;
use App\Subject;
use App\User;
use App\Notification;
use Redirect;
use Session;
use File;
use DB;
use Auth;

class ChatController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = array('status' => 0, 'data' => '','message' => 'Error');

        if ($request->ajax()){
            $data = $request->all();
            $insub['subject'] = 'Regarding Job';//$data['sub'];
            
            $inmsg['msgdata']    = $data['msg'];
            $inmsg['created_at'] = date("Y-m-d H:i:s");
            $inmsg['from_id']    = @Auth::user()->id;
            $inmsg['to_id']      = LERHelper::decryptUrl($data['to_id']);

            DB::beginTransaction();

            try {
                $subInsert = DB::table('subject')->insertGetId($insub);
                $inmsg['subject_id'] = $subInsert;
                $msgInsert = DB::table('messages')->insertGetId($inmsg);
                DB::commit();
                // all good
                $inmsg['msg_at'] = date('d-m-Y',strtotime($inmsg['created_at']));
                $inmsg['user_name'] = @Auth::user()->first_name.' '.@Auth::user()->last_name;
                $inmsg['prof_pic'] = asset('/assets/user/profile_pic').'/'.@Auth::user()->profile_pic;
                $objCht = new Chat();
                $objCht->setNewMsgPosted = "New Message From: ".LERHelper::getFullName($inmsg['from_id']);
                $objCht->msgdata   = $inmsg['msgdata'];
                $objCht->from_id   = LERHelper::getFullName($inmsg['from_id']);
                $objCht->to_idonly = $inmsg['to_id'];
                $objCht->to_id     = LERHelper::getFullName($inmsg['to_id']);
                $objCht->datetimes = $inmsg['created_at'];
                $notify_data['from_id']               = $inmsg['from_id'];
                $notify_data['to_id']                 = $inmsg['to_id'];
                $notify_data['id_redirect']           = $inmsg['from_id'];
                $notify_data['subject']               = $objCht->setNewMsgPosted;
                $notify_data['notification_type']     = 'User Message';
                $notify_data['notification_type_val'] = 'User-Message';
                $add_notify = $this->jobData->saveNotificationsCommon($notify_data);
                $response = array('status' => 1, 'data' => $inmsg,'message' => 'Success');
                if($msgInsert){
                    event(new ChatPosted($objCht)); //To show a notification that a new message has been created
                }
                return response()->json($response);
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                $response['data'] = $e;
                return response()->json($response);
            }
        } else {
            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $full_url = request()->fullUrl();
        $exp = explode("?jid=", $full_url);
        $data['id'] = $id;
        $decryprted_id = LERHelper::decryptUrl($id);
        $noti  = Notification::where('to_id',@Auth::user()->id)
                                ->where('from_id',$decryprted_id)
                                ->where('notification_type',"User Message")
                                ->where('read_status',"Unread")
                                ->get();
        if($noti->count() > 0){
            foreach ($noti as $up_key => $up_value) {
                $upDate['read_status'] = 'Read';
                $upDate['read_at']     = date('Y-m-d h:i:s');
                $notify =  DB::table('notifications')->where('id', $up_value['id'])->update($upDate);  
            }
        }

        $data['otherprofile'] = User::find(LERHelper::decryptUrl($id));
        if(!empty($exp[1])){
            $job_id = LERHelper::decryptUrl($exp[1]);
            $jobData = LERHelper::getJobDetails($job_id);
            $data['job_regarding'] = array('job_id'=>$job_id,'job_name'=>@$jobData[0]['job_title']);
        }
        $data['my_chat'] = DB::select('select * from messages where (from_id = '.@Auth::user()->id.' OR from_id = '.LERHelper::decryptUrl($id).') AND (to_id = '.@Auth::user()->id.' OR to_id = '.LERHelper::decryptUrl($id).') order by created_at asc');
        // $data['my_chat'] = DB::select('select * from messages where (from_id = '.@Auth::user()->id.' OR to_id = '.@Auth::user()->id.') AND (from_id = '.LERHelper::decryptUrl($id).' OR to_id = '.LERHelper::decryptUrl($id).') order by created_at asc');
        return view('chat.chat',$data);
    }

    public function setUserTypingMsg(Request $request){
        $response = array('status' => 0, 'data' => '','message' => 'Error');

        if ($request->ajax()){
            $data = $request->all();
            $objTyp = new Chat();
            $objTyp->setNewMsgType = $data['userName'];
            $user_name = $data['userName'];
            $user_id   = LERHelper::decryptUrl($data['userId']);
            $to_id   = LERHelper::decryptUrl($data['to_id']);
            if(!empty($user_name)){
                event(new UserTypingChat($objTyp)); //To show a typing to another user
            }
        } else {
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
