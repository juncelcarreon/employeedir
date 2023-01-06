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
use App\Mail\InfractionNODNotification;
use App\Mail\InfractionNODAcknowledged;

class DAInfractionController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth::user()->id;

        app('App\Http\Controllers\EmailRemindersController')->reminderInfraction();

        $data['infractions'] = DAInfraction::getInfractions($id);
        $data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));

        if(Auth::user()->isAdmin()){ $data['infractions'] = DAInfraction::getInfractions(); }

        return view('dainfraction.index', $data);
    }

    public function team(Request $request)
    {
        $id = Auth::user()->id;

        $data['infractions'] = DAInfraction::getInfractions($id, 'team');
        $data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));

        return view('dainfraction.team', $data);
    }

    public function create()
    {
        $data['employees'] = User::ActiveEmployees()->AllExceptSuperAdmin()->orderBy('first_name')->get();

        return view('dainfraction.create', $data);
    }

    public function store(Request $request)
    {
        $employee = User::withTrashed()->find($request->employee_id);
        $supervisor = User::find($employee->supervisor_id);
        $manager = User::find($employee->manager_id);
        $file_name = $request->infraction_type.'-'.time();

        $infraction = new DAInfraction();
        $infraction->employee_id = $request->employee_id;
        $infraction->title = $request->title;
        $infraction->infraction_type = $request->infraction_type;
        $infraction->date = date('Y-m-d', strtotime($request->date));
        $infraction->filed_by = Auth::user()->id;
        $infraction->file = '';
        if(!empty($supervisor->id)) { $infraction->supervisor_id = $supervisor->id; }
        if(!empty($manager->id)) { $infraction->manager_id = $manager->id; }

        if ($request->hasFile("file")) {
            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs("infractions/{$request->employee_id}", $request->file, "{$file_name}.pdf");

            $infraction->file = asset($path);
        }

        if($infraction->save()){
            $data['id'] = $infraction->id;
            $data['emp_name'] = strtoupper($employee->first_name);
            $data['title'] = $request->title;
            $data['url'] = url("dainfraction/{$infraction->id}");
            $data['type'] = $request->infraction_type;

            $emails = ['hrd@elink.com.ph','juncelcarreon@elink.com.ph'];
            if(!empty($supervisor->id)) {
                array_push($emails, $supervisor->email);
            }

            if(!empty($manager->id)) {
                array_push($emails, $manager->email);
            }

            if($request->infraction_type == 'NTE') {
                // Mail::to($employee->email)->cc($emails)->send(new InfractionNotification($data));
            } else {
                // Mail::to($employee->email)->cc($emails)->send(new InfractionNODNotification($data));
            }

            return redirect(url("dainfraction/{$infraction->id}"))->with('success', "DA Infraction Successfully Submitted!!");
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function show($id)
    {
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        $item = DAInfraction::withTrashed()->find($id);
        if(empty($item)) {
            return redirect('/404');
            exit;
        }

        $path = 'http://dir.elink.corp/public/infractions//NOD-1673018385.pdf';
        $pdftext = file_get_contents($path);
        $pages = preg_match_all("/\/Page\W/", $pdftext, $dummy);

        $data['infraction'] = $item;
        $data['employee'] = User::withTrashed()->find($item->employee_id);
        $data['filer'] = User::withTrashed()->find($item->filed_by);
        $data['path'] = $path;
        $data['pages'] = $pages;

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
        $file_name = $request->infraction_type.'-'.time();

        $infraction = DAInfraction::withTrashed()->find($request->id);
        $infraction->title = $request->title;
        $infraction->infraction_type = $request->infraction_type;
        $infraction->date = date('Y-m-d', strtotime($request->date));

        if ($request->hasFile("file")) {
            File::delete($infraction->file);

            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs("infractions/{$request->employee_id}", $request->file, "{$file_name}.pdf");

            $infraction->file = asset($path);
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

        $infraction->affixed_name = $request->affixed_name;
        $infraction->acknowledged_date = date('Y-m-d H:i:s');
        if($infraction->infraction_type == 'NTE') {
            $infraction->status = 2;
        } else {
            $infraction->status = 1;
        }

        $employee = User::withTrashed()->find($infraction->employee_id);

        SentEmailArchives::where('employee_id', $employee->id)->where('mail_type', "INFRACTION{$infraction->id}")->update(['status' => 1]);

        if($infraction->save()){
            if($infraction->infraction_type == 'NTE') {
                // Mail::to($employee->email)->cc(['juncelcarreon@elink.com.ph'])->send(new InfractionAcknowledged(['emp_name'=>strtoupper($employee->first_name)]));
            } else{
                // Mail::to($employee->email)->cc(['juncelcarreon@elink.com.ph'])->send(new InfractionNODAcknowledged(['emp_name'=>strtoupper($employee->first_name)]));
            }

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
            return back()->with('success', "{$infraction->infraction_type} - Explanation Successfully Submitted!!");
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }
}
