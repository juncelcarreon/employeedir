<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Mail;
use App\DAInfraction;
use App\SentEmailArchives;
use App\User;
use App\Mail\InfractionAcknowledged;
use App\Mail\InfractionNotification;

class DAInfractionController extends Controller
{
    public function index(Request $request)
    {
        $status = (($request->has('status') && $request->get('status') != "") ? $request->get('status') : 'not-acknowledged');

        app('App\Http\Controllers\EmailRemindersController')->reminderInfraction();

        $data['infractions'] = DAInfraction::getInfractions(null, Auth::user()->id);
        $data['type'] = $status;

        if(Auth::user()->isAdmin()){ $data['infractions'] = DAInfraction::getInfractions(); }

        return view('dainfraction.index', $data);
    }

    public function create()
    {
        $data['employees'] = User::AllExceptSuperAdmin()->get();

        return view('dainfraction.create', $data);
    }

    public function store(Request $request)
    {
        $infractions = count(DAInfraction::getInfractions());
        $infractions = $infractions + 1;

        $infraction = new DAInfraction();
        $infraction->employee_id = $request->employee_id;
        $infraction->title = $request->title;
        $infraction->date = date('Y-m-d', strtotime($request->date));
        $infraction->filed_by = Auth::user()->id;
        $infraction->file = '';

        if ($request->hasFile("file")) {
            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs("infractions/{$request->employee_id}", $request->file, "{$infractions}.pdf");

            $infraction->file = asset('public/'.$path);
        }

        $employee = User::withTrashed()->find($request->employee_id);
        $supervisor = User::find($employee->supervisor_id);
        $manager = User::find($employee->manager_id);

        if($infraction->save()){
            $data['id'] = $infraction->id;
            $data['emp_name'] = strtoupper($employee->first_name);
            $data['title'] = $request->title;
            $data['url'] = url("dainfraction/{$infraction->id}");

            $emails = ['hrd@elink.com.ph'];
            if(!empty($supervisor->id)) {
                array_push($emails, $supervisor->email);
            }

            if(!empty($manager->id)) {
                array_push($emails, $manager->email);
            }

            // Mail::to('juncelcarreon@elink.com.ph')->cc(['ivybarria@elink.com.ph'])->send(new InfractionNotification($data));
            // Mail::to($employee->email)->cc($emails)->send(new InfractionNotification($data));

            return redirect(url("dainfraction/{$infraction->id}"))->with('success', "DA Infraction Successfully Submitted!!");
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function show($id)
    {
        $item = DAInfraction::withTrashed()->find($id);
        if(empty($item)) {
            return redirect('/404');
            exit;
        }

        $data['infraction'] = $item;
        $data['employee'] = User::withTrashed()->find($item->employee_id);
        $data['filer'] = User::withTrashed()->find($item->filed_by);

        return view('dainfraction.show', $data);
    }

    public function edit($id)
    {
        $item = DAInfraction::withTrashed()->find($id);
        if(empty($item)) {
            return redirect('/404');
            exit;
        }

        $data['infraction'] = $item;
        $data['employee'] = User::withTrashed()->find($item->employee_id);

        return view('dainfraction.edit', $data);
    }

    public function update(Request $request)
    {
        $infraction = DAInfraction::withTrashed()->find($request->id);
        $infraction->title = $request->title;
        $infraction->date = date('Y-m-d', strtotime($request->date));

        if ($request->hasFile("file")) {
            File::delete("public/infractions/{$request->employee_id}/{$infraction->id}.pdf");

            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs("infractions/{$request->employee_id}", $request->file, "{$infraction->id}.pdf");

            $infraction->file = asset('public/'.$path);
        }

        if($infraction->save()){
            return back()->with('success', 'DA Infraction Successfully Updated!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function acknowledged(Request $request)
    {
        $infraction = DAInfraction::withTrashed()->find($request->id);
        if(empty($infraction)) {
            return redirect('/404');
            exit;
        }
        $infraction->status = 2;

        $employee = User::withTrashed()->find($infraction->employee_id);

        SentEmailArchives::where('employee_id', $employee->id)->where('mail_type', "INFRACTION{$infraction->id}")->update(['status' => 1]);

        if($infraction->save()){
            // Mail::to('juncelcarreon@elink.com.ph')->cc(['ivybarria@elink.com.ph'])->send(new InfractionAcknowledged(['emp_name'=>strtoupper($employee->first_name)]));
            // Mail::to($employee->email)->send(new InfractionAcknowledged(['emp_name'=>strtoupper($employee->first_name)]));

            return back()->with('success', 'Infraction Successfully Acknowledged!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function explanation(Request $request)
    {
        $infraction = DAInfraction::withTrashed()->find($request->id);
        if(empty($infraction)) {
            return redirect('/404');
            exit;
        }
        $infraction->reason = $request->reason;
        $infraction->status = 1;

        $employee = User::withTrashed()->find($infraction->employee_id);

        if($infraction->save()){
            return back()->with('success', 'NTE - Explanation Successfully Submitted!!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }
}
