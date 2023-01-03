
<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
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

/*
 *
 * Redirection
 */

Route::get('/', function () {
    // Check if user is logged in
	if(Auth::check()){
	    // if user is admin redirect to dashboard
		if(Auth::user()->isAdmin()){
			return redirect('/dashboard');
		}else{
			return redirect('/home');		
		}
	}else{
    	return redirect('/home');	
	}
});

/*
 *
 * Normal User Routes
 */
Route::get('/home', 'HomeController@index')->name('home');
Route::get('employees', 'EmployeeInfoController@employees');
Route::get('employees-card', 'EmployeeInfoController@card');
Route::get('profile/{id}', 'EmployeeInfoController@profile');

/*
 *
 * Normal User / JSON Results
 */
Route::get('newhires', 'HomeController@newhires');
Route::get('events/calendar', 'EventsController@calendar');
Route::get('events/lists', 'EventsController@lists');


/*
 *
 * Custom Auth Routes
 */
Route::get('logout', function(){
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::post('login', 'EmployeeInfoController@login');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/password', 'PasswordResetController@index')->name('password.forgot');
Route::post('/password', 'PasswordResetController@reset')->name('password.reset');
Route::get('/password/reset/{token}', 'PasswordResetController@confirmReset')->name('password.reset-confirm');
/*
 *
 * Resource Controller
 */

Route::resource('referral', 'ReferralController');
Route::resource('events', 'EventsController');
Route::resource('settings', 'SettingsController');
/*
 *
 * Error routes
 */

Route::get('403', 'ErrorController@forbidden')->name('403');
Route::get('404', 'ErrorController@notfound')->name('404');


Route::middleware(['auth'])->group(function(){

    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', 'HomeController@dashboard');
        Route::resource('department', 'DepartmentController');
        Route::resource('employee_info', 'EmployeeInfoController');
        Route::resource('activities', 'ActivityController');

        Route::get('posts/{id}/enabled', 'PostController@enabled');
        Route::resource('posts', 'PostController');
        
        Route::get('employees/separated', 'EmployeeInfoController@separatedEmployees');
        Route::get('employees/{id}/reactivate', 'EmployeeInfoController@reactivate');
        Route::get('upload/info','EmployeeInfoController@uploadInfo');
        Route::get('hierarchy', 'HierarchyController@hierarchy');
        Route::get('setting', 'SettingController@index');
        Route::post('setting/updateHierarchy', 'SettingController@updateHierarchy');
        Route::post('setting/updateAttendance', 'SettingController@updateAttendance');
        Route::post('setting/updateDirectives', 'SettingController@updateDirectives');
        Route::post('setting/updateDresscode', 'SettingController@updateDresscode');
        Route::post('hierarchy', 'HierarchyController@updateHierarchy');
        Route::post('upload/info/process','EmployeeInfoController@processUploadInfo');
        Route::post('upload/info/avega','EmployeeInfoController@processAvega');
    });
    Route::get('employee/{id}/changepassword', 'EmployeeInfoController@changepassword');
    Route::get('forms/avega', 'EmployeeInfoController@formAvega');
    Route::resource('leave', 'LeaveController');
    Route::post('export/save', 'LeaveController@processSave');
    Route::post('leave/recommend', 'LeaveController@recommend');
    Route::post('leave/approve', 'LeaveController@approve');
    Route::post('leave/noted', 'LeaveController@noted');
    Route::post('leave/decline', 'LeaveController@decline');
    Route::post('leave/update', 'LeaveController@updateLeaveEntry');
    Route::post('leave/credits', 'LeaveController@updatecredits');
    Route::get('testleave', 'LeaveController@test');
    Route::post('employee/{id}/savepassword', 'EmployeeInfoController@savepassword');
    Route::post('leave/rack','LeaveController@deleteLeaveDate');
    Route::post('save-profile','EmployeeInfoController@saveProfile');
    Route::post('save-conversion', 'LeaveController@saveConversion');
    Route::post('save-transfer', 'EmployeeInfoController@saveMovements');
    Route::post('send-45','UtilsController@sendProb_55');
    Route::post('save-break-info','TimeKeepingController@saveBreakInfo');
    Route::get('approved-lists', 'LeaveController@approveLists');

    Route::resource('overtime', 'OvertimeController');
    Route::post('overtime/recommend', 'OvertimeController@recommend');
    Route::post('overtime/approve', 'OvertimeController@approve');
    // Route::post('overtime/noted', 'OvertimeController@noted');
    Route::post('overtime/decline', 'OvertimeController@decline');
    Route::post('overtime/update', 'OvertimeController@update');
    Route::post('overtime/complete', 'OvertimeController@complete');
    Route::post('overtime/revert', 'OvertimeController@revert');
    Route::post('overtime/verification', 'OvertimeController@verification');
    Route::get('overtime/timekeeping/{id}', 'OvertimeController@timekeeping');
    Route::get('team-overtime', 'OvertimeController@team');

    Route::resource('undertime', 'UndertimeController');
    Route::post('undertime/recommend', 'UndertimeController@recommend');
    Route::post('undertime/approve', 'UndertimeController@approve');
    // Route::post('undertime/noted', 'UndertimeController@noted');
    Route::post('undertime/decline', 'UndertimeController@decline');
    Route::post('undertime/update', 'UndertimeController@update');
    Route::get('team-undertime', 'UndertimeController@team');

    Route::resource('dainfraction', 'DAInfractionController');
    Route::post('dainfraction/acknowledged', 'DAInfractionController@acknowledged');
    Route::post('dainfraction/explanation', 'DAInfractionController@explanation');
    Route::post('dainfraction/update', 'DAInfractionController@update');
    Route::get('team-dainfraction', 'DAInfractionController@team');
    Route::get('dainfraction-pdf/{id}', 'DAInfractionController@pdf');

    Route::resource('survey', 'SurveyController');

    Route::get('recommend-request-info/{id}', 'EmployeeInfoController@recommendApproval');
    Route::get('approve-request-info/{id}', 'EmployeeInfoController@approveChangeProfile');
    Route::get('leave-credits', 'LeaveController@credits')->name('leave-credits');
    Route::get('time-keeping', 'TimeKeepingController@personalTimeKeeping');
    Route::get('sup-view', 'TimeKeepingController@supView');
    Route::post('process-linkee', 'EmployeeInfoController@processLinkees')->name('add-linkees');
    Route::post('delete-linkee', 'EmployeeInfoController@deleteLinkees')->name('remove-linkees');
    Route::get('process-linkee', 'EmployeeInfoController@processLinkees');

    Route::get('coaching-session', 'CoachingController@mainCoaching');
    Route::get('linkee-pending', 'CoachingController@forAcknowledgement');
    Route::get('own-linking', 'CoachingController@thisLink');
    Route::get('download-linking', 'CoachingController@downloadLinking');

    /* Linking Session: Quick Link */
    Route::get('quick-link-list', 'CoachingController@listQLs');
    Route::get('quick-link/{id}', 'CoachingController@viewQL');
    Route::get('quick-link-edit/{id}', 'CoachingController@editQL');
    Route::get('quick-link-acknowledge/{id}', 'CoachingController@acknowledgeQL');
    Route::post('add-quick-link', 'CoachingController@addQL')->name('add-quick-link');
    Route::post('update-quick-link', 'CoachingController@updateQL')->name('update-quick-link');
    Route::post('acknowledged-quick-link', 'CoachingController@acknowledgedQL')->name('acknowledged-quick-link');
    /* End Linking Session: Quick Link */

    /* Linking Session: Cementing Expectation */
    Route::get('ce-expectation-list', 'CoachingController@listCEs');
    Route::get('ce-expectation/{id}', 'CoachingController@viewCE');
    Route::get('ce-expectation-edit/{id}', 'CoachingController@editCE');
    Route::get('ce-expectation-acknowledge/{id}', 'CoachingController@acknowledgeCE');
    Route::post('add-ce-expectation', 'CoachingController@addCE')->name('add-ce-expectation');
    Route::post('update-ce-expectation', 'CoachingController@updateCE')->name('update-ce-expectation');
    Route::post('acknowledged-ce-expectation', 'CoachingController@acknowledgedCE')->name('acknowledged-ce-expectation');
    /* End Linking Session: Cementing Expectation */

    /* Linking Session: Accountability Setting */
    Route::get('acc-set/{id}','CoachingController@viewAS');
    Route::get('acc-set-edit/{id}', 'CoachingController@editAS');
    Route::get('acc-set-acknowledge/{id}', 'CoachingController@acknowledgeAS');
    Route::get('acc-set-list', 'CoachingController@listASs');
    Route::post('add-acc-set', 'CoachingController@addAS')->name('add-acc-set');
    Route::post('update-acc-set', 'CoachingController@updateAS')->name('update-acc-set');
    Route::post('acknowledged-acc-set', 'CoachingController@acknowledgedAS')->name('acknowledged-acc-set');
    /* End Linking Session: Accountability Setting */

    /* Linking Session: Skill Development Activities */
    Route::get('skill-dev-act/{id}','CoachingController@viewSDA');
    Route::get('skill-dev-act-edit/{id}', 'CoachingController@editSDA');
    Route::get('skill-dev-act-acknowledge/{id}', 'CoachingController@acknowledgeSDA');
    Route::get('skill-dev-act-list', 'CoachingController@listSDAs');
    Route::post('add-skill-dev-act', 'CoachingController@addSDA')->name('add-skill-dev-act');
    Route::post('update-skill-dev-act', 'CoachingController@updateSDA')->name('update-skill-dev-act');
    Route::post('acknowledged-skill-dev-act', 'CoachingController@acknowledgedSDA')->name('acknowledged-skill-dev-act');
    /* End Linking Session: Skill Development Activities */

    /* Linking Session: Getting To Know You */
    Route::get('gtky/{id}', 'CoachingController@viewGTKY');
    Route::get('gtky-edit/{id}', 'CoachingController@editGTKY');
    Route::get('gtky-acknowledge/{id}', 'CoachingController@acknowledgeGTKY');
    Route::get('gtky-list', 'CoachingController@listGTKYs');
    Route::post('add-gtky', 'CoachingController@addGTKY')->name('add-gtky');
    Route::post('update-gtky', 'CoachingController@updateGTKY')->name('update-gtky');
    Route::post('acknowledged-gtky', 'CoachingController@acknowledgedGTKY')->name('acknowledged-gtky');
    /* End Linking Session: Getting To Know You */

    /* Linking Session: Skill Building */
    Route::get('skill-building/{id}','CoachingController@viewSB');
    Route::get('skill-building-edit/{id}', 'CoachingController@editSB');
    Route::get('skill-building-acknowledge/{id}', 'CoachingController@acknowledgeSB');
    Route::get('skill-building-list', 'CoachingController@listSBs');
    Route::post('add-skill-building', 'CoachingController@addSB')->name('add-skill-building');
    Route::post('update-skill-building', 'CoachingController@updateSB')->name('update-skill-building');
    Route::post('acknowledged-skill-building', 'CoachingController@acknowledgedSB')->name('acknowledged-skill-building');
    /* End Linking Session: Skill Building */

    /* Linking Session: Goal Setting */
    Route::get('goal-setting/{id}', 'CoachingController@viewGS');
    Route::get('goal-setting-edit/{id}', 'CoachingController@editGS');
    Route::get('goal-setting-acknowledge/{id}', 'CoachingController@acknowledgeGS');
    Route::get('goal-setting-list', 'CoachingController@listGSs');
    Route::post('add-goal-setting', 'CoachingController@addGS')->name('add-goal-setting');
    Route::post('update-goal-setting', 'CoachingController@updateGS')->name('update-goal-setting');
    Route::post('acknowledged-goal-setting', 'CoachingController@acknowledgedGS')->name('acknowledged-goal-setting');
    /* End Linking Session: Goal Setting */

    Route::get('has-admin','UtilsController@setThisAdmin');
    Route::get('expanded-credits', 'LeaveController@leaveCredits')->name('expanded.credits');
    Route::get('expanded-tracker', 'LeaveController@leaveTracker');
    Route::get('past-credits/{year}', 'LeaveController@pastCredits');
    Route::get('leave-report', 'LeaveController@reports');
    Route::get('display-report', 'LeaveController@displayReport');
    Route::get('patch-credits', 'LeaveController@patchCredits');
    Route::get('download-credits', 'LeaveController@xlsCredits');
    Route::get('download-report', 'LeaveController@downloadReport');
    Route::get('download-credits-ver2', 'LeaveController@xlsCreditsVer2');
    Route::get('credits-conversion', 'LeaveController@conversion');
    Route::get('approved-leaves', 'LeaveController@approveLeaves');
    Route::get('team-approves', 'LeaveController@teamApproves');
    Route::get('for-approval', 'LeaveController@forApproval');
    Route::get('cancelled-leaves', 'LeaveController@cancelledLeaves');
    Route::get('team-cancelled', 'LeaveController@teamCancelled');
    Route::get('get-dates/{id}', 'LeaveController@getLeaveDates');
    Route::get('leave/credits/{employee_id}', 'LeaveController@editcredits');
    Route::get('export/test', 'LeaveController@uploadCredits');
    Route::get('myprofile', 'EmployeeInfoController@myprofile');
    Route::get('update-profile', 'EmployeeInfoController@updateProfile');
    Route::get('download-filter', 'EmployeeInfoController@downloadFilter');
    Route::get('download-inactive', 'EmployeeInfoController@downloadInactive');
    Route::get('browse-transfer', 'EmployeeInfoController@searchMovements');
    //Route::get('increment-credits','LeaveController@creditIncrement');
    Route::get('inc-crd/{month}','LeaveController@creditIncrementVer2');
    Route::get('view-rec/{id}','EmployeeInfoController@viewRecord');
    Route::get('api-leaves','LeaveController@apiLeaveList');
    Route::get('notify-2-5','UtilsController@notifyProbis_2_5');
    Route::get('patch-dept','UtilsController@patchDeptCode');
    Route::get('verify-2-5','UtilsController@verifyProbis_2_5');
    Route::get('stop-2-5/{id}','UtilsController@stopNotify_2_5');
    Route::get('stop-5-5/{id}','UtilsController@stopNotify_5_5');
    Route::get('verify-5-5','UtilsController@verifyProbis_5_5');
    Route::get('notify-5-5','UtilsController@notifyProbis_5_5');
    Route::get('process-45','UtilsController@processProbis_4_5');
    Route::get('view-s-d','UtilsController@viewSDetails');
    Route::get('exportdownload', 'EmployeeInfoController@exportdownload');
    Route::get('employees/sync', function(){
        return view('employee.sync');
    });
    Route::get('/archive-leave-credits', 'ArchiveController@archiveLeaveCredits');
    Route::get('/unarchive-leave-credits', 'ArchiveController@unArchiveLeaveCredits');
    Route::get('stop-reminder/{id}', 'EmailRemindersController@stopReminder');
});

/**
 *  Custom Routes
 */
Route::get('showactivities/{id}', 'ActivityController@show');
Route::post('import/birthdays', "EmployeeInfoController@importbday");
Route::post('api/login', 'EmployeeInfoController@loginAPI');
Route::post('api/v2/login', 'EmployeeInfoController@loginAPIv2');
Route::get('api/session', 'EmployeeInfoController@session');
Route::get('run', 'Controller@run');
Route::get('increment-credits','LeaveController@creditIncrement');
Route::get('/send-email-reminder', 'EmailReminderController@index');
Route::get('/send-email-reminders', 'EmailRemindersController@index');
Route::get('/send-email-reminder-to-leader', 'EmailReminderController@remindTeamLeader');
Route::get('/send-email-reminder-approval', 'EmailRemindersController@reminderApproval');
Route::get('/maintenance', 'TestController@viewMaintenance');
