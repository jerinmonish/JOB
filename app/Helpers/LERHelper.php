<?php
/**
 * PHP version 7 and Laravel version 5.6.22
 *
 * @package         Helper
 * @Purpose         TO Manage Helper Functions
 * @File            STCHelper.php
 * @Author          A.C Jerin Monish
 * @Modified By     A.C Jerin Monish
 * @Created Date    17-05-2018
 */
namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Image;
use Mail;
use DB;
use URL;
use App\User;
use App\Job;
use App\JobApplied;
use App\JobView;
use App\JobSubscription;
use App\JobTags;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LERHelper
{

    // To encrypt id in url
    public static function encryptUrl($id) {
        if($id){
            $id = base64_encode(($id + 122354125410));
            return $id;
        }
    }

    // To decrypt id in url
    public static function decryptUrl($id) {
        if(is_numeric(base64_decode($id))){
            $id = explode(",", base64_decode($id))[0] - 122354125410;
            return $id;
        } 
        abort(404);
    }


    public static function set_uploads($request,$file_name,$path,$filedelete=''){
        $docupload = $file_name.'-'.time().$request->jd_desc->extension(); 
        $res = $request->jd_desc->move(public_path($path), $docupload);

        if(!empty($filedelete)){                
            if(\File::exists(public_path($path.$filedelete))){
              \File::delete(public_path($path.$filedelete));
            }
        }
        return $docupload;
    }

    public static function check_job_applied($job_id,$employee_id,$employer_id){
        $jobApplied = JobApplied::select('*')
                                    ->where('job_id', $job_id)
                                    ->where('employee_id', $employee_id)
                                    ->where('job_posted_id', $employer_id)
                                    ->get();
        if(!empty($jobApplied[0]->id)){
            $return['data'] = $jobApplied[0];
        } else {
            $return['data'] = 0;
        }
        return $return;
    }

    public static function check_job_subscribed($employee_id,$employer_id){
        $jobApplied = JobSubscription::select('*')
                                    ->where('employee_id', $employee_id)
                                    ->where('employer_id', $employer_id)
                                    ->where('status', "Active")
                                    ->get();
        if(!empty($jobApplied[0]->id)){
            $return['data'] = $jobApplied[0];
        } else {
            $return['data'] = 0;
        }
        return $return;
    }

    // To get my notifciations
    public static function getMyNotifications($id) {
        if($id){
            $get_event = Notification::select('*')
                                        ->where('to_id', $id)
                                        ->where('read_status', 'Unread')
                                        ->where('read_at', NULL)
                                        ->OrderBy('id', 'desc')
                                        ->get();
            $returnNotification = [];
            $returnNotification['count'] = count($get_event);
            foreach ($get_event as $NotKey => $NotValue) {
                if($NotValue->notification_type == "Job Posted"){
                    $returnNotification['notification'][] = '<a href="'.route("view-job",array(static::encryptUrl(@$NotValue->id_redirect))).'?nid='.static::encryptUrl($NotValue->id).'" class="dropdown-item">'.$NotValue->subject.'</a>';
                }
                if($NotValue->notification_type == "User Subscribed" || $NotValue->notification_type == "User Unsubscribed"){
                    $returnNotification['notification'][] = '<a href="#" class="dropdown-item">'.$NotValue->subject.' <span class="notificationRMV" style="color:red" title="Mark as Read" data-arr="'.static::encryptUrl($NotValue->id).'">X</span></a>';
                }
                if($NotValue->notification_type == "User Message" && $NotValue->to_id == @Auth::user()->id){
                    $returnNotification['notification'][] = '<a href="'.route("chat.show",array(static::encryptUrl(@$NotValue->id_redirect))).'" class="dropdown-item">'.$NotValue->subject.' <span class="notificationRMV" style="color:red" title="Mark as Read" data-arr="'.static::encryptUrl($NotValue->id).'">X</span></a>';
                }
            }
            return $returnNotification;
        } else {
            return false;
        }
    }

    public static function jobViewCount($id){
        $jobCount = JobView::select('*')
                                    ->where('job_id', $id)
                                    ->get();
        $input = $jobCount->count();
        if($input > 0){
            $input = number_format($input);
            $input_count = substr_count($input, ',');
            $arr = array(1=>'K','M','B','T');
            if(isset($arr[(int)$input_count])){

               return substr($input,0,(-1*$input_count)*4).$arr[(int)$input_count];
            } 
            else {
                return $input.' Views <!--<i class="fa fa-eye"></i>-->';
            }
        } else {
            return '';
        }
    }

    public static function getJobDetails($id){
        $jobCount = Job::select('*')
                            ->where('id', $id)
                            ->get();
        if($jobCount->count() > 0){
            return $jobCount;
        } else {
            return false;
        }
    }

    // To User name
    public static function getFullName($id) {
        if($id){
            $get_name = User::select('first_name','last_name')->where('id', $id)->first();
            return ucfirst(@$get_name['first_name']).' '.@$get_name['last_name'];
        } else {
            return false;
        }
    }
    
    // To get multiple tag names
    public static function getTagNameMultiple($data) {
        // echo '<pre>';print_r(trim($data));exit;
        if($data){
            $expTagM = explode(",", trim($data));
            foreach ($expTagM as $keyTagM => $valueTagM) {
                $getTagName = JobTags::select('tag_name')->where('id', $valueTagM)->first();
                if(!empty($getTagName->tag_name)){
                    $finalTagName[] = $getTagName->tag_name;
                }
            }
            $impTagM = implode(", ", $finalTagName);
            return $impTagM;
        } else {
            return NULL;
        }
    }

    // To set first 19 chars
    public static function charRestrictions($id) {
        if($id){
                $charStr = strlen($id);
            if($charStr > 19){
                $charStr = substr($id, 0, 19);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    // To set first 140 chars
    public static function charRestrictionsNews($id) {
        if($id){
            $charStr = strlen($id);
            if($charStr > 140){
                $charStr = substr($id, 0, 140);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    // To set first 140 chars
    public static function charRestrictionsFooterNews($id) {
        if($id){
            $charStr = strlen($id);
            if($charStr > 35){
                $charStr = substr($id, 0, 35);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    public static function formatSizeUnits($bytes){
        if ($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }elseif ($bytes >= 1024){
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }elseif ($bytes > 1){
            $bytes = $bytes . ' bytes';
        }elseif ($bytes == 1){
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
        return $bytes;
}

    // To set first 25 chars
    public static function charRestrictionsArt($id) {
        if($id){
                $charStr = strlen($id);
            if($charStr > 25){
                $charStr = substr($id, 0, 25);
                $setChar = $charStr.'...';
            } else {
                $setChar = $id;
            }
            return $setChar;
        }
    }

    // To load donated date
    public static function dateAlone($data) {
        if($data){
            $date = date("d", strtotime($data));
            return $date;
        } else {
            return $data;
        }
    }

    // To load donated month
    public static function monthAlone($data) {
        if($data){
            $date = date("M", strtotime($data));
            return $date;
        } else {
            return $data;
        }
    }

    // To load donated year
    public static function yearRange() {
        for($i=1700;$i<=date('Y');$i++) {
            $year_data[$i] = $i;
        }
        return $year_data;
    }

    // To load category year
    public static function catYear() {
        for($i=1947;$i<=date('Y');$i++) {
            $year_data[$i] = $i;
        }
        return $year_data;
    }

    // To get grade name
    public static function getGrade($id) {
        if($id){
            $get_grade = CoinsGrade::select('grade')->where('id', $id)->first();
            return $get_grade['grade'];
        } else {
            return false;
        }
    }

    // To get country name
    public static function getCountry($id) {
        if($id){
            $get_country = Country::select('country_name')->where('id', $id)->first();
            return $get_country['country_name'];
        } else {
            return false;
        }
    }

    public static function dbcheck(){
        $check = env('ONLINEDB');
        if($check == 1){
            try {
                    DB::connection('mysql2')->getPdo();
                    if(DB::connection('mysql2')->getDatabaseName()){
                        //echo "Yes! Successfully connected to the DB: " . DB::connection('mysql2')->getDatabaseName();
                        return 1;
                    }
                } catch (\Exception $e) {
                    return 0;
                }
        } else {
            return 0;
        }
    }

    // To get Continents name
    public static function getContinents($id) {
        if($id){
            $get_country = Continents::select('continent_name')->where('id', $id)->first();
            return $get_country['continent_name'];
        } else {
            return false;
        }
    }

    // To get events name
    public static function getEvents($id) {
        if($id){
            $get_event = Events::select('event_name')->where('id', $id)->first();
            return $get_event['event_name'];
        } else {
            return false;
        }
    }

    // To get keywords name
    public static function getKeywords($id) {
        if($id){
            $get_keywords = Keywords::select('keywords')->where('id', $id)->first();
            return $get_keywords['keywords'];
        } else {
            return false;
        }
    }

    // To get all country
    public static function getAllCountry() {
            $all_country['country'] = Country::all();
            return $all_country;
    }

    // To get state name
    public static function getState($id) {
        if($id){
            $get_state = State::select('state_name')->where('id', $id)->first();
            return $get_state['country_name'];
        } else {
            return false;
        }
    }

    // To get all country
    public static function getAllPhotoGallery($id) {
        if($id){
            $photoGallery   = PhotoGallery::select('*')->where('id', $id)->first();
            $photoGalleryre = PhotoGallery::select('*')
                                            ->where('main_category_id', $photoGallery['main_category_id'])
                                            ->where('sub_category_id', $photoGallery['sub_category_id'])
                                            ->where('album_id', $photoGallery['album_id'])
                                            ->where('deleted_at', '=', Null)
                                            ->get();
            $data['main_category_id'] = $photoGallery['main_category_id'];
            $data['sub_category_id']  = $photoGallery['sub_category_id'];
            $data['album_id']         = $photoGallery['album_id'];
            $data['all_data']         = $photoGalleryre;
            return $data;
        } else {
            return false;
        }
    }

    // To get main category name
    public static function getMainCategoryId($id) {
        if($id){
            $getCatName = MainCategory::select('category_name')->where('id', $id)->first();
            return $getCatName;
        } else {
            return false;
        }
    }

    // To get main category name
    public static function getSubCatIdPictures($id,$mainCatId ) {
        if($id){
            $getCatName = PhotoGallery::select('*')->where('sub_category_id', $id)->where('main_category_id', $mainCatId)->first();
            return $getCatName;
        } else {
            return false;
        }
    }

    // To get photogallery and sub category images
    public static function getPhotoGallery($id) {
        if($id){
            $getCatAll = PhotoGallery::where('main_category_id', $id)->groupBy('sub_category_id')->where('status', 'Active')->where('deleted_at',NULL)->OrderBy('id', 'desc')->get();
            return $getCatAll;
        } else {
            return false;
        }
    }

    // To get photogallery based on album id
    public static function getPhotoGalleryAlbum($id) {
        if($id){
            $getCatAll = PhotoGallery::where('sub_category_id', $id)->groupBy('album_id')->where('status', 'Active')->where('deleted_at',NULL)->OrderBy('id', 'desc')->get();
            return $getCatAll;
        } else {
            return false;
        }
    }

    // To get first letter caps
    public static function firstLetterCaps($id) {
        if($id){
            $capLetter = ucfirst($id);
            return $capLetter;
        } else {
            return false;
        }
    }

    // To get subcategory name
    public static function getSubCategoryId($id) {
        if($id){
            $getSubCatName = SubCategory::select('title')->where('id', $id)->first();
            return $getSubCatName;
        } else {
            return false;
        }
    }

    // To get album name
    public static function getAlbumID($id) {
        if($id){
            $getAlbName = Album::select('title')->where('id', $id)->first();
            return $getAlbName;
        } else {
            return false;
        }
    }

    // To get album name
    public static function getAlbumName($id) {
        if($id){
            $getAlbName = Album::select('title')->where('id', $id)->first();
            return $getAlbName->title;
        } else {
            return false;
        }
    }

    // To set unique image name
    public static function setImageName($name) {
        if($name){
            $set_name = time().$name;
            return $set_name;
        } else {
            return false;
        }
    }

    // To set pagination per page
    public static function setPaginationNo() {
        $pageSize = 9;
        return  $pageSize;
    }

    // To get Image name
    public static function comImageName($path,$get_img){
        //die($path.'/'.$get_img);
        if($path && $get_img){
            return $path.'/'.$get_img;
        } else {
            $src = asset('public/assets/images/noimages.jpg');
            return $src;
        }
    }

    // To get company name
    public static function getOrganisationName($id) {
        if($id){
            $get_name = User::select('organisation_name')->where('id', $id)->first();
            return $get_name['organisation_name'];
        } else {
            return false;
        }
    }

    // To User name
    public static function getUserImage($id) {
        if($id){
            $get_name = User::select('profile_pic')->where('id', $id)->first();
            return $get_name['profile_pic'];
        } else {
            return false;
        }
    }

    // format date to india format
    public static function formatDate($date=false,$format = 'd-m-Y') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            /*$date = new \DateTime();
            return $date->format($format);*/
            return 'Nil';
        }
    }

    // format date to india format
    public static function manuFormatDate($date=false,$format = 'd-m-Y') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $date = new \DateTime();
            return $date->format($format);
        }
    }

    // format date to india format
    public static function adminViewDate($date=false,$format = 'd-M-Y h:i:s A') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $curDate = date("d-M-Y H:i:s");
            return $curDate;
        }
    }


    // format date to mysql format
    public static function formatMysqlDate($date,$format = 'Y-m-d') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $date = new \DateTime();
            return $date->format($format);
        }
    }

     /*
    * return the number with the given limit - particularly for the float numbers
    */
    public static function mysqlDateTime($date=FALSE, $format = 'Y-m-d h:m:s'){
       if($date){
            return date($format, strtotime($date));
       }else{
            return date($format);
       }
    }

    /*
     *  This is the function to return seo title
     */
	 
    public static function getSeo($seo) {
		$str = strtolower($seo);
		$seoTitle = strtolower(str_replace(array('  ', ' '), '-', preg_replace('/[^a-zA-Z0-9 s]/', '', trim($str))));
		return $seoTitle;
    }

	/*
     *  This is the function to return order by
     */
     
    public static function get_order_by() {
        $array = (['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',]);
        return $array;
    }


     /**
     * To fetch the news & events 
     *
     * @return value
     */
    public static function home_news_events()
    { 
        $data['news_events'] = NewsEvents::OrderBy('id', 'desc')->take(3)->where('status', 1)->get();
        return view('frontend.includes.news_events', $data);
    }

    // format date to News Events
    public static function formatNewsEvents($date,$format = 'M d, Y') {
        if($date) {
            $date = new \DateTime($date);
            return $date->format($format);
        }else{
            $date = new \DateTime();
            return $date->format($format);
        }
    }

     /**
     * To fetch the Slider 
     *
     * @return array
     */
    public static function home_slider()
    { 
        $data['slider'] = Slider::OrderBy('order_by', 'asc')->where('status', 'Active')->get();
        return view('frontend.includes.slider', $data);
    }

    /**
     * To fetch the contact us from cms
     *
     * @return value
     */
    public static function homeContactUs()
    { 
        $data['cms'] = Cms::where('status', 'Active')->where('seo_title', 'contact-us-1')->first();
        
        return $data;
    }

    /**
     * Display the tagged photo
     * 
     * @return value
     */
    public static function getTaggedPhotosCount()
    {
        $data['taggedPhotoCount'] = PhotoTagging::where('admin_status', 'Inactive')->count();
        return $data;
    }

    /**
     * To fetch the contact us from cms
     *
     * @return value
     */
    public static function homePhotoGallery()
    { 
        $data['photoGallery'] = PhotoGallery::where('status', 'Active')->take(16)->inRandomOrder()->get();
        
        return $data;
    }

    /**
     * To fetch the count of photo gallery
     *
     * @return value
     */
    public static function photoGalleryCount()
    { 
        $data['photoGallery'] = PhotoGallery::where('status', 'Active')->count();
        
        return $data;
    }

    /**
     * To fetch the count of coins
     *
     * @return value
     */
    public static function coinsCount()
    { 
        $data['coins'] = Coins::where('status', 'Active')->count();
        
        return $data;
    }

    /**
     * To fetch the coins
     *
     * @return value
     */
    public static function coinsTitle($title)
    { 
        $data['coins'] = Coins::where('status', 'Active')->where('id', $title)->first();
        
        return $data['coins']['title'];
    }

    /**
     * To fetch the stamps
     *
     * @return value
     */
    public static function stampsTitle($title)
    { 
        $data['stamps'] = Stamps::where('status', 'Active')->where('id', $title)->first();
        
        return $data['stamps']['title'];
    }

    /**
     * To fetch the count of stamps
     *
     * @return value
     */
    public static function stampsCount()
    { 
        $data['stamps'] = Stamps::where('status', 'Active')->count();
        
        return $data;
    }

    /**
     * To fetch the count of artifacts
     *
     * @return value
     */
    public static function artifactsCount()
    { 
        $data['artifacts'] = Artifacts::where('status', 'Active')->count();
        
        return $data;
    }

    /**
     * To fetch the count of users
     *
     * @return value
     */
    public static function usersCountAll()
    { 
        $data['users'] = User::where('user_type', 'user')->count();
        
        return $data;
    }

    /**
     * To fetch the count of users today date
     *
     * @return value
     */
    public static function usersCountToday()
    { 
        $data['usersToday'] = User::where('user_type', 'user')->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        
        return $data;
    }

    /**
     * To fetch the count of users yesterday date
     *
     * @return value
     */
    public static function usersCountYesterday()
    { 
        $data['usersYesterday'] = User::where('user_type', 'user')->whereDate('created_at', '=', Carbon::yesterday())->count();
        
        return $data;
    }

    /**
     * To fetch the count of users last week date
     *
     * @return value
     */
    public static function usersCountLastWeek()
    { 
        $data['monday'] = date("Y-m-d", strtotime("last week monday"));
        $data['sunday'] = date("Y-m-d", strtotime("last week sunday"));
        $data['usersLastWeek'] = User::where('user_type', 'user')->whereBetween('created_at',[$data['monday'],$data['sunday']])->count();
        
        return $data;
    }

    /**
     * To fetch the count of users last month date
     *
     * @return value
     */
    public static function usersCountLastMonth()
    { 
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $data['usersLastMonth'] = User::where('user_type', 'user')->whereBetween('created_at',[$fromDate,$tillDate])->count();
        return $data;
    }

    /**
     * To fetch the count of users last year date
     *
     * @return value
     */
    public static function usersCountLastYear()
    { 
        $data['usersLastYear'] = User::where('user_type', 'user')->whereYear('created_at', date('Y', strtotime('last year')))->count();
        return $data;
    }

    /**
     * To fetch the count of Feedback On Photos 
     *
     * @return value
     */
    public static function feedbackCountAll()
    { 
        $data['feedbackAll'] = FeedbackOnPhotos::count();
        
        return $data;
    }

    /**
     * To fetch the count of Feedback On Photos today date
     *
     * @return value
     */
    public static function feedbackCountToday()
    { 
        $data['feedbackToday'] = FeedbackOnPhotos::where('status', 'Active')->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        
        return $data;
    }

    /**
     * To fetch the count of user Request Files Count 
     *
     * @return value
     */
    public static function userRequestFilesCountAll()
    { 
        $data['userRequestFilesAll'] = UserRequestFiles::count();
        
        return $data;
    }

    /**
     * To fetch the count of user Request Files Count today date
     *
     * @return value
     */
    public static function userRequestFilesCountToday()
    { 
        $data['userRequestFilesToday'] = UserRequestFiles::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        
        return $data;
    }

    /**
     * To fetch the count of tag request all
     *
     * @return value
     */
    public static function tagCountAll()
    { 
        $data['tag'] = PhotoTagging::count();
        
        return $data;
    }

    /**
     * To fetch the count of tag request today date
     *
     * @return value
     */
    public static function tagCountToday()
    { 
        $data['tagToday'] = PhotoTagging::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count();
        
        return $data;
    }

    /**
     * To fetch the count of tag request yesterday date
     *
     * @return value
     */
    public static function tagCountYesterday()
    { 
        $data['tagYesterday'] = PhotoTagging::whereDate('created_at', '=', Carbon::yesterday())->count();
        
        return $data;
    }

    /**
     * To fetch the count of tag request last week date
     *
     * @return value
     */
    public static function tagCountLastWeek()
    { 
        $data['monday'] = date("Y-m-d", strtotime("last week monday"));
        $data['sunday'] = date("Y-m-d", strtotime("last week sunday"));
        $data['tagLastWeek'] = PhotoTagging::whereBetween('created_at',[$data['monday'],$data['sunday']])->count();
        
        return $data;
    }

    /**
     * To fetch the count of tag request last month date
     *
     * @return value
     */
    public static function tagCountLastMonth()
    { 
        $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        $data['tagLastMonth'] = PhotoTagging::whereBetween('created_at',[$fromDate,$tillDate])->count();
        return $data;
    }

    /**
     * To fetch the count of tag request last year date
     *
     * @return value
     */
    public static function tagCountLastYear()
    { 
        $data['tagLastYear'] = PhotoTagging::whereYear('created_at', date('Y', strtotime('last year')))->count();
        return $data;
    }

    /**
     * To insert Logs 
     *
     * @return array
     */
    public static function logs($module_name,$description)
    {   $user_id = Auth::id();
        $ip = $_SERVER['SERVER_ADDR'];
        $userAgent = $_SERVER["HTTP_USER_AGENT"];
        $devicesTypes = array(
            "Computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
            "Tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
            "Mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
            "Bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
        );
        foreach($devicesTypes as $deviceType => $devices) {           
            foreach($devices as $device) {
                if(preg_match("/" . $device . "/i", $userAgent)) {
                    $deviceName = $deviceType;
                }
            }
        }

        $values = array('user_id' => $user_id,'module_name' => $module_name,'description'=>$description,'ip'=>$ip,'device'=>$deviceName);
        $result = DB::table('logs')->insert($values);
        $dbcheck    = STCHelper::dbcheck();
        if($dbcheck == 1){
            $datas = DB::connection('mysql2')->table('logs')->insert($values);
        }
        return $result;

    }

    /**
     * To check whether the profile is updated 
     *
     * @return array
     */
    public static function checkProfileUpdate($id)
    {
        if($id){
            $data = User::where('id', $id)->where('profile_update_status', 'Yes')->count();
            return $data;
        }
    }

    // To get photogallery and sub category images
    public static function getPhotoGalleryImage($main_id,$sub_id) {
        if($main_id && $sub_id){
            $getCatAll = PhotoGallery::where('main_category_id', $main_id)->where('sub_category_id', $sub_id)->groupBy('main_category_id','sub_category_id')->where('status', 'Active')->orderBy('main_category_id', 'DESC')->get();
            return $getCatAll;
        } else {
            return false;
        }
    }
    // To get photogallery and sub category images
    public static function getPhotoGalleryImage1($main_id,$sub_id) {
        if($main_id && $sub_id){
            $getCatAll = PhotoGallery::where('main_category_id', $main_id)->where('sub_category_id', $sub_id)->where('status', 'Active')->get();
            return $getCatAll;
        } else {
            return false;
        }
    }

    // To get main category name
    public static function getMainCategoryName($id) {
        if($id){
            $getCatName = MainCategory::select('category_name')->where('id', $id)->first();
            
            return $getCatName->category_name;
        } else {
            return false;
        }
    }

    /**
     * To updated the auto generated password for a particular email
     *
     * @return array
     */
    public static function setpasswordAttribute($password,$email){ 
        $data = DB::update('update users set password = ? where email = ?',[$password,$email]);
        $dbcheck    = STCHelper::dbcheck();
        if($dbcheck == 1){
            $datas = DB::connection('mysql2')->update('update users set password = ? where email = ?',[$password,$email]);
        }
        return $data;
    }

    /**
     * To get messages send to particular id
     *
     * @return array
     */
    public static function getMessages($id) {
        if($id){
            $getMsg = Messages::where('user_id', $id)->groupBy('user_id')->where('status', 'Sent')->where('viewStatus','Not Viewed')->where('deleted_at',NULL)->OrderBy('id', 'desc')->count();
            return $getMsg;
        } else {
            return false;
        }
    }

    // To get photogallery and sub category images
    public static function getPhotoGalleryImages($id) {
        if($id){
            $getImageName = PhotoGallery::where('id', $id)->where('status', 'Active')->first();
            if($getImageName){
                return $getImageName->main_photo;
            } else {
                return 'noimage';
            }
            
        } else {
            return false;
        }
    }
}