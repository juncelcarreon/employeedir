<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\UndertimeRequest;
use App\User;
use App\Mail\UndertimeApproved;
use App\Mail\UndertimeDeclined;
use App\Mail\UndertimeNotification;
use App\Mail\UndertimeReminder;
use App\Mail\UndertimeSelfNotification;
use DateTime;

class UndertimeController extends Controller
{

    public function index(Request $request)
    {
        $status = (($request->has('status') && $request->get('status') != "") ? $request->get('status') : 'pending');
        $id = Auth::user()->id;

        $data['undertime_request'] = UndertimeRequest::getUndertime($status);
        $data['type'] = $status;
        $data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));

        if(Auth::user()->isAdmin()){ $data['undertime_request'] = UndertimeRequest::getUndertime($status); }

        return view('request.undertime_request', $data);
    }

    public function team(Request $request)
    {
        $status = (($request->has('status') && $request->get('status') != "") ? $request->get('status') : 'pending');
        $id = Auth::user()->id;

        $data['undertime_request'] = UndertimeRequest::getUndertime($status, 'team', $id);
        $data['type'] = $status;

        return view('request.undertime_team', $data);
    }

    public function create()
    {
        return view('request.undertime_create');
    }

    public function store(Request $request)
    {
        $undertime = new UndertimeRequest();
        $undertime->employee_id = Auth::user()->id;
        $undertime->date = date('Y-m-d', strtotime($request->date));
        $undertime->time_in = date('Y-m-d H:i:s', strtotime($request->time_in));
        $undertime->time_out = date('Y-m-d H:i:s', strtotime($request->time_out));
        $undertime->reason = $request->reason;
        $undertime->save();

        $supervisor = User::find(Auth::user()->supervisor_id);
        $manager = User::find(Auth::user()->manager_id);

        $no_of_hours = '';
        if(!empty($request->time_in) && !empty($request->time_out)) {
            $start = new DateTime($request->time_in);
            $end = $start->diff(new DateTime($request->time_out));
            $end->d = $end->d * 24;
            $end->h = ($end->h - 1) + $end->d;

            $no_of_hours = "{$end->h} hours";
        }

        $data['id'] = $undertime->id;
        $data['requester_name'] = strtoupper(Auth::user()->fullname());
        $data['date'] = date('F d, Y',strtotime($request->date));
        $data['time_in'] = date('F d, Y H:i A',strtotime($request->time_in));
        $data['time_out'] = date('F d, Y H:i A',strtotime($request->time_out));
        $data['no_of_hours'] = $no_of_hours;
        $data['url'] = url("undertime/{$undertime->id}");
        $data['emp_name'] = 'CC MAIL';
        $data['reason'] = $request->reason;

        if(!empty($supervisor->id)) {
            $data['emp_name'] = strtoupper($supervisor->first_name);
            // Mail::to($supervisor->email)->cc('ivybarria@elink.com.ph')->send(new UndertimeNotification($data));
        }

        if(!empty($manager->id)) {
            $data['emp_name'] = strtoupper($manager->first_name);
            // Mail::to($manager->email)->cc('ivybarria@elink.com.ph')->send(new UndertimeNotification($data));
        }

        Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new UndertimeNotification($data));
        Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new UndertimeSelfNotification(['emp_name' => strtoupper(Auth::user()->first_name)]));

        // Mail::to(Auth::user()->email)->cc('ivybarria@elink.com.ph')->send(new UndertimeSelfNotification(['emp_name' => strtoupper(Auth::user()->first_name)]));

        return redirect($data['url'])->with('success', 'Undertime Request Successfully Submitted!!');
    }

    public function show($id)
    {
        $item = UndertimeRequest::getUndertime('', 'show', $id);
        if(count($item) <= 0) {
            return redirect('/404');
            exit;
        }
        $undertime = $item[0];
        $manager = User::find($undertime->manager_id);
        $supervisor = User::find($undertime->supervisor_id);

        $data = [
            'undertime'   => $undertime,
            'manager'    => $manager,
            'supervisor' => $supervisor
        ];

        return view('request.undertime_show', $data);
    }

    public function edit($id)
    {
        $item = UndertimeRequest::getUndertime('', 'show', $id);
        if(count($item) <= 0) {
            return redirect('/404');
            exit;
        }
        $undertime = $item[0];

        $data = [
            'undertime'   => $undertime
        ];

        return view('request.undertime_edit', $data);
    }

    public function update(Request $request)
    {
        $undertime = UndertimeRequest::withTrashed()->find($request->id);
        if(empty($undertime)) {
            return redirect('/404');
            exit;
        }
        $undertime->date = date('Y-m-d', strtotime($request->date));
        $undertime->time_in = date('Y-m-d H:i:s', strtotime($request->time_in));
        $undertime->time_out = date('Y-m-d H:i:s', strtotime($request->time_out));
        $undertime->reason = $request->reason;

        if($undertime->save()){
            return back()->with('success', 'Undertime Request Successfully Updated!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function recommend(Request $request)
    {
        $undertime = UndertimeRequest::withTrashed()->find($request->id);
        if(empty($undertime)) {
            return redirect('/404');
            exit;
        }
        $undertime->recommend_id = Auth::user()->id;
        $undertime->recommend_date = date('Y-m-d H:i:s');

        $employee = User::withTrashed()->find($undertime->employee_id);
        $manager = User::find($employee->manager_id);

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->fullname()),
            'id' => $request->id,
            'url' => url("undertime/{$undertime->id}")
        ];

        if($undertime->save()){
            if(empty($manager)) {
                $data['leader_name'] = 'HR DEPARTMENT';

                // Mail::to('hrd@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new UndertimeReminder($data));
                Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new UndertimeReminder($data));
            } else {
                $data['leader_name'] = strtoupper($manager->first_name); 

                // Mail::to($manager->email)->cc('ivybarria@elink.com.ph')->send(new UndertimeReminder($data));
                Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new UndertimeReminder($data));
            }

            return back()->with('success', 'Undertime Request successfully recommended for approval.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function approve(Request $request)
    {
        $undertime = UndertimeRequest::withTrashed()->find($request->id);
        if(empty($undertime)) {
            return redirect('/404');
            exit;
        }
        $undertime->approved_id = Auth::user()->id;
        $undertime->approved_date = date('Y-m-d H:i:s');
        $undertime->status = 'APPROVED';

        $employee = User::withTrashed()->find($undertime->employee_id);

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'date' => $undertime->date
        ];

        if($undertime->save()){
            // Mail::to($employee->email)->cc('ivybarria@elink.com.ph')->send(new UndertimeApproved($data));
            Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new UndertimeApproved($data));

            return back()->with('success', 'Undertime Request successfully approved. . .');
        } else {
            return back()->with('error', 'Something went wrong. . .');
        }
    }

    public function decline(Request $request)
    {
        $undertime = UndertimeRequest::withTrashed()->find($request->id);
        if(empty($undertime)) {
            return redirect('/404');
            exit;
        }
        $undertime->declined_id = Auth::user()->id;
        $undertime->declined_date = date('Y-m-d H:i:s');
        $undertime->declined_reason = $request->reason_for_disapproval;
        $undertime->status = 'DECLINED';

        $employee = User::withTrashed()->find($undertime->employee_id);

        // SEND EMAIL NOTIFICATION
        $data = [
            'emp_name' => strtoupper($employee->first_name),
            'date' => $undertime->date
        ];

        if($undertime->save()){
            // Mail::to($employee->email)->cc('ivybarria@elink.com.ph')->send(new UndertimeDeclined($data));
            Mail::to('juncelcarreon@elink.com.ph')->cc('ivybarria@elink.com.ph')->send(new UndertimeDeclined($data));

            return back()->with('success', 'Undertime Request successfully declined.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

}