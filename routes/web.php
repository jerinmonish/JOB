<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Repository Demo
/*Route::get('/','CustomerController@index');
Route::get('/user/{user_id}','CustomerController@show');*/

Route::get('/', function () {
	if(Auth::check()) {
        return redirect()->route('home');
    } else {
    	return view('auth.login');
    }
});

Route::get('/clear-cache', function() {
        $clearCache = Artisan::call('cache:clear');
        $clearConfig = Artisan::call('config:clear'); 
         return Redirect::to('/');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('demodd', 'EmployeeController@demodd')->name('demodd');

Route::group(['middleware' => ['App\Http\Middleware\AdminMiddleware','auth']], function()
{
	Route::get('list-user', 'AdminController@listSiteUsers')->name('list-user');
	Route::get('list_user', 'AdminController@listAllUsers')->name('list_user');
	Route::get('view-user', 'AdminController@listAllUsers')->name('view-user');
	Route::get('list-jobs', 'AdminController@listAdminJobs')->name('list-jobs');
	Route::get('list_all_job', 'AdminController@listAllJobs')->name('list_all_job');
	Route::get('view-ijob/{id}', ['as' => 'view-ijob','uses' => 'AdminController@jobInDetail']);
	
	Route::get('change-user-status/{status}/{id}', ['as' => 'change-user-status','uses' => 'AdminController@changeUserStatus']);
});

Route::group(['middleware' => ['App\Http\Middleware\EmployerMiddleware','auth']], function()
{
	Route::resource('job','JobController');
	Route::get('list-active-user', 'EmployerController@listActiveEmployee')->name('list-active-user');
	Route::get('list_active_user', 'EmployerController@listAllActiveUsers')->name('list_active_user');
	Route::get('list-active-jobs', 'JobController@index')->name('list-active-jobs');
	Route::get('list_active_job', 'JobController@listAllActivejobs')->name('list_active_job');
	Route::get('job.delete/{id}', ['as' => 'job.delete','uses' => 'JobController@destroy']);
	Route::get('list_employer_applied_candidate', ['as' => 'list_employer_applied_candidate','uses' => 'EmployerController@listallCandidatesappliedtomyjob']);
	Route::get('applied-candidate', ['as' => 'applied-candidate','uses' => 'EmployerController@appliedCandidate']);
	Route::get('job-applied-candidate/{id}', ['as' => 'job-applied-candidate','uses' => 'EmployerController@viewCandiateApplied']);
	Route::get('list_subscribed_employee', 'EmployerController@listAllSubscribedEmployee')->name('list_subscribed_employee');
	Route::get('view-subscribed-employee', ['as' => 'view-subscribed-employee','uses' => 'EmployerController@ViewSubscribedEmployee']);
});

Route::group(['middleware' => ['App\Http\Middleware\EmployeeMiddleware','auth']], function()
{
	Route::get('jobs', 'EmployeeController@listAllJobs')->name('jobs');
	Route::get('listAllEmpJobs', 'EmployeeController@listAllEmpJobs')->name('listAllEmpJobs');
	Route::get('view-job/{id}', ['as' => 'view-job','uses' => 'EmployeeController@viewJob']);
	Route::get('apply-job/{id}', ['as' => 'apply-job','uses' => 'EmployeeController@applyJob']);
	Route::get('listAllAppliedJobs', 'EmployeeController@listAllAppliedJobs')->name('listAllAppliedJobs');
	Route::get('applied-job', ['as' => 'applied-job','uses' => 'EmployeeController@appliedJob']);
	Route::get('detail-applied-job/{jobapplied_id}', ['as' => 'detail-applied-job','uses' => 'EmployeeController@appliedjobIndetail']);
	Route::post('subscribe-job', ['as' => 'subscribe-job','uses' => 'EmployeeController@subscribeJob']);
	Route::post('unsubscribe-job', ['as' => 'unsubscribe-job','uses' => 'EmployeeController@unsubscribeJob']);
	Route::get('list_subscribed_employer', 'EmployeeController@listAllSubscribedEmployer')->name('list_subscribed_employer');
	Route::get('view-subscribed-employer', ['as' => 'view-subscribed-employer','uses' => 'EmployeeController@ViewSubscribedEmployer']);
});

Route::group(['middleware' => 'auth'], function()
{
	Route::resource('chat','ChatController');
	Route::get('profile', 'HomeController@profile')->name('profile');
	Route::post('update-profile', array('as' => 'update-profile', 'uses' => 'HomeController@profileUpdate'));
	Route::get('change-password', 'HomeController@changePassword')->name('change-password');
	Route::post('update-password', array('as' => 'update-password', 'uses' => 'HomeController@passwordUpdate'));
	Route::get('list_employer_jobs/{id}', ['as' => 'list_employer_jobs','uses' => 'HomeController@listAllEmployerJobsView']);
	Route::get('employer-jobs/{id}', ['as' => 'employer-jobs','uses' => 'HomeController@listAllEmployerJobs']);
	Route::get('view-iuser/{id}', ['as' => 'view-iuser','uses' => 'AdminController@userInDetail']);
	Route::post('mark-as-read', array('as' => 'mark-as-read', 'uses' => 'HomeController@notificationRead'));
	Route::get('profile', 'HomeController@profile')->name('profile');
	Route::post('user_typing', array('as' => 'user_typing', 'uses' => 'ChatController@setUserTypingMsg'));
	Route::post('get_state_id', array('as' => 'get_state_id', 'uses' => 'HomeController@get_state_base_id'));
});
