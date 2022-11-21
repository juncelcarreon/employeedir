<?php

namespace App\Http\Controllers;

use App\Mail\ProbitionaryEmailNotificationA;
use App\Mail\ProbitionaryEmailNotificationB;
use App\Mail\LeaveReminder;
use App\Mail\InfractionReminder;
use App\User;
use App\SentEmailArchives;
use App\LeaveRequest;
use App\DAInfraction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class EmailRemindersController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '-1');
        $employees = User::where('is_regular', 0)->whereNull('deleted_at')->whereNotNull('hired_date')->where('id', '<>', 1)->where('status', 1)->get();

        foreach($employees as $key=>$employee) {
            $hired_date = Carbon::parse($employee->hired_date)->format('Y-m-d');
            $today_date = now()->format('Y-m-d');

            $three_hired_date = Carbon::createFromFormat('Y-m-d', $hired_date);
            $three_month_date = $three_hired_date->addMonths(3)->subDay(1)->format('Y-m-d');
            $three_month_review_date = Carbon::createFromFormat('Y-m-d', $three_month_date);
            $three_month_difference = strtotime($three_month_review_date) - strtotime(now());
            $three_month_days_left = abs(round($three_month_difference / 86400));
            $three_month_evaluation = SentEmailArchives::where('employee_id', $employee->id)->where('mail_type', 'EVALUATION03')->first();

            $five_hired_date = Carbon::createFromFormat('Y-m-d', $hired_date);
            $five_month_date = $five_hired_date->addMonths(5)->subDay(1)->format('Y-m-d');
            $five_month_review_date = Carbon::createFromFormat('Y-m-d', $five_month_date);
            $five_month_difference = strtotime($five_month_review_date) - strtotime(now());
            $five_month_days_left = abs(round($five_month_difference / 86400));
            $five_month_evaluation = SentEmailArchives::where('employee_id', $employee->id)->where('mail_type', 'EVALUATION05')->first();

            if($three_month_days_left <= 15 && $three_month_difference >= 0) {
                $data = [
                    'emp_id' => $employee->id,
                    'emp_name' => strtoupper($employee->fullname()),
                    'date_hired' => date('Y-m-d', strtotime($employee->hired_date)),
                    'date' => $three_month_date,
                    'due_date' => $three_month_review_date->subDays(5)->format('Y-m-d')
                ];

                $supervisor = User::find($employee->supervisor_id);
                if(!empty($supervisor)) {
                    if(empty($three_month_evaluation)){
                        $archives = new SentEmailArchives();
                        $archives->employee_id    = $employee->id;
                        $archives->mail_type      = 'EVALUATION03';
                        $archives->save();

                        $data['id'] = $archives->id;
                        Mail::to($supervisor->email)->cc(['hrd@elink.com.ph','juncelcarreon@elink.com.ph'])->send(new ProbitionaryEmailNotificationA($data));
                    } else{
                        if($three_month_evaluation->status == 0 && date('Y-m-d', strtotime($three_month_evaluation->updated_at)) != date('Y-m-d')) {
                            $data['id'] = $three_month_evaluation->id;

                            SentEmailArchives::where('id', $three_month_evaluation->id)->update(['updated_at' => date('Y-m-d H:i:s')]);
                            // Mail::to($supervisor->email)->cc(['hrd@elink.com.ph','juncelcarreon@elink.com.ph'])->send(new ProbitionaryEmailNotificationA($data));
                        }
                    }
                }
            }

            if($five_month_days_left <= 15 && $five_month_difference >= 0) {
                $data = [
                    'emp_id' => $employee->id,
                    'emp_name' => strtoupper($employee->fullname()),
                    'date_hired' => date('Y-m-d', strtotime($employee->hired_date)),
                    'date' => $five_month_date,
                    'due_date' => $five_month_review_date->subDays(5)->format('Y-m-d')
                ];

                $supervisor = User::find($employee->supervisor_id);
                if(!empty($supervisor)) {
                    if(empty($five_month_evaluation)){
                        $archives = new SentEmailArchives();
                        $archives->employee_id    = $employee->id;
                        $archives->mail_type      = 'EVALUATION05';
                        $archives->save();

                        $data['id'] = $archives->id;
                        Mail::to($supervisor->email)->cc(['hrd@elink.com.ph','juncelcarreon@elink.com.ph'])->send(new ProbitionaryEmailNotificationB($data));
                    } else{
                        if($five_month_evaluation->status == 0 && date('Y-m-d', strtotime($five_month_evaluation->updated_at)) != date('Y-m-d')) {
                            $data['id'] = $five_month_evaluation->id;

                            SentEmailArchives::where('id', $five_month_evaluation->id)->update(['updated_at' => date('Y-m-d H:i:s')]);
                            // Mail::to($supervisor->email)->cc(['hrd@elink.com.ph','juncelcarreon@elink.com.ph'])->send(new ProbitionaryEmailNotificationB($data));
                        }
                    }
                }
            }
        }
    }

    public function stopReminder($id)
    {
        $reminder = SentEmailArchives::find($id);

       if(Auth::user()->dept_code == 'HR01' || Auth::user()->id == 2797  || Auth::user()->isAdmin()){
            SentEmailArchives::where('id', $reminder->id)->update(['status' => '1']);

            return 'Item Complete';
       }else{
            return 'Access Denied';
       }
    }

    public function reminderApproval()
    {
        ini_set('memory_limit', '-1');

        foreach(LeaveRequest::getLeave() as $request) {
            $difference = strtotime(now()) - strtotime($request->date_filed);
            $days = abs(round($difference / 86400));
            $supervisor = User::find($request->supervisor_id);
            $manager = User::find($request->manager_id);
            $leave_archive = SentEmailArchives::where('employee_id', $request->employee_id)->where('mail_type', "APPROVAL{$request->id}")->where('status', 1)->first();
            $data = [
                'emp_name' => strtoupper($request->last_name .', '. $request->first_name),
                'id' => $request->id
            ];

            if($days >= 3 && empty($leave_archive->id)) {
                $archives = new SentEmailArchives();
                $archives->employee_id  = $request->employee_id;
                $archives->mail_type    = 'APPROVAL'.$request->id;
                $archives->status       = 1;
                $archives->save();

                $data_arr[$request->id]['name'] = 'add';

                if (!empty($supervisor) && empty($request->recommending_approval_by_signed_date)) {
                    $data['leader_name'] = strtoupper($supervisor->first_name);

                    if(!empty($manager)) { 
                        if($manager->id != $supervisor->id) {
                            // Mail::to($supervisor->email)->cc('juncelcarreon@elink.com.ph')->send(new LeaveReminder($data));
                        }
                    } else {
                        // Mail::to($supervisor->email)->cc('juncelcarreon@elink.com.ph')->send(new LeaveReminder($data));
                    }
                }

                if (!empty($manager)) { 
                    $data['leader_name'] = strtoupper($manager->first_name); 

                    // Mail::to($manager->email)->cc('juncelcarreon@elink.com.ph')->send(new LeaveReminder($data));
                } else {
                    $data['leader_name'] = 'HR DEPARTMENT';

                    // Mail::to('hrd@elink.com.ph')->cc('juncelcarreon@elink.com.ph')->send(new LeaveReminder($data));
                }
            }
        }
    }

    public function reminderInfraction()
    {
        ini_set('memory_limit', '-1');

        $data_array = [];
        foreach(DAInfraction::getInfractions(0) as $infraction) {
            $difference = strtotime(now()) - strtotime($infraction->created_at);
            $days = abs(round($difference / 86400));
            $archive = SentEmailArchives::where('employee_id', $infraction->employee_id)->where('mail_type', "INFRACTION{$infraction->id}")->first();
            $data = [
                'emp_name' => strtoupper($infraction->first_name),
                'url' => url("dainfraction/{$infraction->id}")
            ];

            if($days >= 1) {
                if(empty($archive->id)) {
                    $archives = new SentEmailArchives();
                    $archives->employee_id  = $infraction->employee_id;
                    $archives->mail_type    = 'INFRACTION'.$infraction->id;
                    $archives->status       = 0;
                    $archives->save();

                    // Mail::to('juncelcarreon@elink.com.ph')->send(new InfractionReminder($data));
                    // Mail::to($infraction->email)->send(new InfractionReminder($data));
                } else {
                    if(date('Y-m-d', strtotime($archive->updated_at)) != date('Y-m-d')) {
                        SentEmailArchives::where('id', $archive->id)->update(['updated_at' => date('Y-m-d H:i:s')]);

                        // Mail::to('juncelcarreon@elink.com.ph')->send(new InfractionReminder($data));
                        // Mail::to($infraction->email)->send(new InfractionReminder($data));
                    }
                }
            }
        }
    }

    public function remindTeamLeader()
    {   
        $todayDate = now();
        $leaves =  LeaveRequest::where('status',1)->whereYear('created_at', '=', $todayDate->year)->where('approve_status_id',NULL)->orWhere('approve_status_id',0)->get();

        foreach($leaves as $leave)
        {
            $employee = DB::table('employee_info')->find($leave->employee_id);
            $supervisor = DB::table('employee_info')->where(DB::raw('concat(last_name,", ", first_name)'), 'LIKE', "%$employee->supervisor_name%")->first();
            $manager = DB::table('employee_info')->where(DB::raw('concat(last_name,", ", first_name)'), 'LIKE', "%$employee->manager_name%")->first();

            $recipients = [
                'hrd@elink.com.ph',
                $supervisor->email,
                $manager->email,
            ];

            $fileDate = Carbon::parse($leave->date_filed);
            if($fileDate->addDays(5)->format('Y-m-d') == $todayDate->format('Y-m-d')){
                $leave_obj = ['leave' => $leave, 'details' => LeaveRequestDetails::where("leave_id",$leave->id)->get()];
                // Mail::to($recipients)->send(new LeaveNotification($leave_obj));
            }
        }
    }
}
