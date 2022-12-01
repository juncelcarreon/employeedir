<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\OvertimeRequest;
use App\OvertimeRequestDetails;
use App\User;
use App\Mail\OvertimeApproved;
use App\Mail\OvertimeCompleted;
use App\Mail\OvertimeDeclined;
use App\Mail\OvertimeNotification;
use App\Mail\OvertimeReminder;
use App\Mail\OvertimeRevert;
use App\Mail\OvertimeSelfNotification;
use App\Mail\OvertimeTimekeeping;
use App\Mail\OvertimeVerification;

class OvertimeController extends Controller
{

    public function index(Request $request)
    {
        $status = (($request->has('status') && $request->get('status') != "") ? $request->get('status') : 'pending');
        $id = Auth::user()->id;

        $data['overtime_request'] = OvertimeRequest::getOvertime($status, 'user', $id);
        $data['type'] = $status;
        $data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));

        if(Auth::user()->isAdmin()){ $data['overtime_request'] = OvertimeRequest::getOvertime($status); }

        return view('request.overtime_request', $data);
    }

    public function team(Request $request)
    {
        $status = (($request->has('status') && $request->get('status') != "") ? $request->get('status') : 'pending');
        $id = Auth::user()->id;

        $data['overtime_request'] = OvertimeRequest::getOvertime($status, 'team', $id);
        $data['type'] = $status;

        return view('request.overtime_team', $data);
    }

    public function create()
    {
        return view('request.overtime_create');
    }

    public function store(Request $request)
    {
        $overtime = new OvertimeRequest();
        $overtime->employee_id = Auth::user()->id;
        $overtime->reason = $request->reason;
        $overtime->save();

        $obj = [];
        foreach($request->date as $key=>$date) {
            $detail = new OvertimeRequestDetails();
            $detail->overtime_id = $overtime->id;
            $detail->date = date('Y-m-d', strtotime($date));
            $detail->no_of_hours = $request->no_of_hours[$key];
            $detail->save();

            $obj[$key]['date'] = date('Y-m-d', strtotime($date));
            $obj[$key]['no_of_hours'] = $request->no_of_hours[$key];
        }

        $supervisor = User::find(Auth::user()->supervisor_id);
        $manager = User::find(Auth::user()->manager_id);

        $data['id'] = $overtime->id;
        $data['requester_name'] = strtoupper(Auth::user()->fullname());
        $data['details'] = $obj;
        $data['url'] = url("overtime/{$overtime->id}");
        $data['emp_name'] = 'CC MAIL';
        $data['reason'] = $request->reason;

        if(!empty($supervisor->id)) {
            $data['emp_name'] = strtoupper($supervisor->first_name);
            // Mail::to($supervisor->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeNotification($data));
        }

        if(!empty($manager->id)) {
            $data['emp_name'] = strtoupper($manager->first_name);
            // Mail::to($manager->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeNotification($data));
        }

        // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeNotification($data));
        // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeSelfNotification(['emp_name' => strtoupper(Auth::user()->first_name)]));

        // Mail::to(Auth::user()->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeSelfNotification(['emp_name' => strtoupper(Auth::user()->first_name)]));

        return redirect($data['url'])->with('success', 'Overtime Request Successfully Submitted!!');
    }

    public function show($id)
    {
        $item = OvertimeRequest::getOvertime('', 'show', $id);
        if(count($item) <= 0) {
            return redirect('/404');
            exit;
        }

        $data['overtime'] = $item[0];
        $data['manager'] = User::find($item[0]->manager_id);
        $data['supervisor'] = User::find($item[0]->supervisor_id);

        return view('request.overtime_show', $data);
    }

    public function edit($id)
    {
        $item = OvertimeRequest::getOvertime('', 'show', $id);
        if(count($item) <= 0) {
            return redirect('/404');
            exit;
        }

        $data['overtime'] = $item[0];

        return view('request.overtime_edit', $data);
    }

    public function update(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->reason = $request->reason;

        OvertimeRequestDetails::where('overtime_id', $overtime->id)->forceDelete();

        foreach($request->date as $key=>$date) {
            $detail = new OvertimeRequestDetails();
            $detail->overtime_id = $overtime->id;
            $detail->date = date('Y-m-d', strtotime($date));
            $detail->no_of_hours = $request->no_of_hours[$key];
            if(!empty($request->time_in[$key])) {
                $detail->time_in = date('Y-m-d H:i:s', strtotime($request->time_in[$key]));
            }
            if(!empty($request->time_out[$key])) {
                $detail->time_out = date('Y-m-d H:i:s', strtotime($request->time_out[$key]));
            }
            $detail->save();
        }

        if($overtime->save()){
            return back()->with('success', 'Overtime Request Successfully Updated!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function recommend(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->recommend_id = Auth::user()->id;
        $overtime->recommend_date = date('Y-m-d H:i:s');

        $employee = User::withTrashed()->find($overtime->employee_id);
        $manager = User::find($employee->manager_id);

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->fullname()),
            'id' => $request->id,
            'url' => url("overtime/{$overtime->id}")
        ];

        if($overtime->save()){
            if(empty($manager)) {
                $data['leader_name'] = 'HR DEPARTMENT';

                // Mail::to('hrd@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeReminder($data));
                // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeReminder($data));
            } else {
                $data['leader_name'] = strtoupper($manager->first_name); 

                // Mail::to($manager->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeReminder($data));
                // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeReminder($data));
            }

            return back()->with('success', 'Overtime Request successfully recommended for approval.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function approve(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->approved_id = Auth::user()->id;
        $overtime->approved_date = date('Y-m-d H:i:s');
        $overtime->approved_reason = null;
        $overtime->status = 'APPROVED';

        $employee = User::withTrashed()->find($overtime->employee_id);
        $details = DB::select("SELECT * FROM `overtime_request_details` WHERE `overtime_request_details`.`overtime_id` = {$overtime->id} ORDER BY `overtime_request_details`.`date`");

        $obj = [];
        foreach($details as $key=>$detail) {
            $obj[$key]['date'] = date('Y-m-d', strtotime($detail->date));
            $obj[$key]['no_of_hours'] = $detail->no_of_hours;
        }

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'date' => $details[0]->date,
            'details' => $obj,
            'reason' => $overtime->reason
        ];

        if($overtime->save()){
            // Mail::to($employee->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeApproved($data));
            // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeApproved($data));

            return back()->with('success', 'Overtime Request successfully approved. . .');
        } else {
            return back()->with('error', 'Something went wrong. . .');
        }
    }

    public function decline(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->declined_id = Auth::user()->id;
        $overtime->declined_date = date('Y-m-d H:i:s');
        $overtime->declined_reason = $request->reason_for_disapproval;
        $overtime->status = 'DECLINED';

        $employee = User::withTrashed()->find($overtime->employee_id);
        $details = DB::select("SELECT * FROM `overtime_request_details` WHERE `overtime_request_details`.`overtime_id` = {$overtime->id} ORDER BY `overtime_request_details`.`date`");

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'date' => $details[0]->date
        ];

        if($overtime->save()){
            // Mail::to($employee->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeDeclined($data));
            // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeDeclined($data));

            return back()->with('success', 'Overtime Request successfully declined.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function timekeeping($id)
    {
        $item = OvertimeRequest::getOvertime('', 'show', $id);
        if(count($item) <= 0) {
            return redirect('/404');
            exit;
        }

        $data['overtime'] = $item[0];

        return view('request.overtime_timekeeping', $data);
    }

    public function verification(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }

        $i = 0;
        $obj = [];
        foreach($request->ids as $key=>$id) {
            $detail = OvertimeRequestDetails::withTrashed()->find($id);
            if(!empty($request->time_in[$key])) {
                $detail->time_in = date('Y-m-d H:i:s', strtotime($request->time_in[$key]));
            }
            if(!empty($request->time_out[$key])) {
                $detail->time_out = date('Y-m-d H:i:s', strtotime($request->time_out[$key]));
            }
            $detail->save();

            if(empty($request->time_in[$key]) || empty($request->time_out[$key])) { $i++; }

            $obj[$key]['date'] = date('Y-m-d', strtotime($detail->date));
            $obj[$key]['time_in'] = date('Y-m-d H:i:s', strtotime($request->time_in[$key]));
            $obj[$key]['time_out'] = date('Y-m-d H:i:s', strtotime($request->time_out[$key]));
        }

        $employee = User::withTrashed()->find($overtime->employee_id);
        $manager = User::find($employee->manager_id);

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'reason' =>$overtime->reason,
            'url' => url("overtime/{$overtime->id}"),
            'details' => $obj
        ];

        if($i == 0) {
            $overtime->status = 'VERIFYING';
            $overtime->save();

            if(empty($manager)) {
                $data['leader_name'] = 'HR DEPARTMENT';

                // Mail::to('hrd@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeVerification($data));
                // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeVerification($data));
            } else {
                $data['leader_name'] = strtoupper($manager->first_name); 

                // Mail::to($manager->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeVerification($data));
                // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeVerification($data));
            }

            return redirect($data['url'])->with('success', 'Overtime Timekeeping successfully updated.');
        } else {
            return back()->with('success', 'Overtime Timekeeping successfully updated.');
        }
    }

    public function complete(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->completed_id = Auth::user()->id;
        $overtime->completed_date = date('Y-m-d H:i:s');
        $overtime->status = 'COMPLETED';

        $employee = User::withTrashed()->find($overtime->employee_id);
        $details = DB::select("SELECT * FROM `overtime_request_details` WHERE `overtime_request_details`.`overtime_id` = {$overtime->id} ORDER BY `overtime_request_details`.`date`");

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'url' => url("overtime/{$overtime->id}"),
            'date' => $details[0]->date
        ];

        if($overtime->save()){
            // Mail::to($employee->email)->send(new OvertimeCompleted($data));
            // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeCompleted($data));

            // Mail::to('timekeeping@elink.com.ph')->send(new OvertimeTimekeeping($data));
            // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeTimekeeping($data));

            return back()->with('success', 'Overtime Request successfully completed. . .');
        } else {
            return back()->with('error', 'Something went wrong. . .');
        }
    }

    public function revert(Request $request)
    {
        $overtime = OvertimeRequest::withTrashed()->find($request->id);
        if(empty($overtime)) {
            return redirect('/404');
            exit;
        }
        $overtime->approved_reason = $request->reason_for_reverting;
        $overtime->status = 'APPROVED';

        $employee = User::withTrashed()->find($overtime->employee_id);

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'url' => url("overtime/{$overtime->id}")
        ];

        if($overtime->save()){
            // Mail::to($employee->email)->cc('ivybarria@elink.com.ph')->send(new OvertimeRevert($data));
            // Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new OvertimeRevert($data));

            return back()->with('success', 'Overtime Request successfully reverted.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }
}
