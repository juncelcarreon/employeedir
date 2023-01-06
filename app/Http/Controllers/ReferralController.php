<?php

namespace App\Http\Controllers;

use App\Mail\ReferralSubmitted;
use App\User;
use App\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReferralController extends Controller
{
    public function index()
    {
        $data['referrals'] = Referral::orderByDesc('created_at')->get();

        return view('referral.index', $data);
    }

    public function create()
    {
        return view('referral.create');
    }

    public function store(Request $request)
    {
        $referral = new Referral();
        $referral->referrer_first_name = $request->referrer_first_name;
        $referral->referrer_middle_name = $request->referrer_middle_name;
        $referral->referrer_last_name = $request->referrer_last_name;
        $referral->referrer_department = $request->referrer_department;
        $referral->referral_first_name = $request->referral_first_name;
        $referral->referral_middle_name = $request->referral_middle_name;
        $referral->referral_last_name = $request->referral_last_name;
        $referral->referral_contact_number = $request->referral_contact_number;
        $referral->referral_email = $request->referral_email;
        $referral->position_applied = $request->position_applied;

        $users = User::ActiveEmployees()->where('dept_code', 'TLA01')->select('email')->get();

        $emails = ['juncelcarreon@elink.com.ph'];
        foreach($users as $user) { array_push($emails, $user->email); }

        if($referral->save()){
            // Mail::to('hrd@elink.com.ph')->cc($emails)->send(new ReferralSubmitted($referral));

            return back()->with('success', 'Referral successfully sent to the ERP Team. Thank you.');
        }

        return back()->with('error', 'Something went wrong');
    }

    public function show($id)
    {
        $referral = Referral::find($id);
        if(empty($referral)){
            return redirect(url('404'));
        }

        $referral->acknowledged = 1;
        $referral->save();

        $data['referral'] = $referral;

        return view('referral.show', $data);
    }

    public function destroy($id)
    {
        $referral = Referral::find($id);
        if(empty($referral)){
            return redirect(url('404'));
        }

        if($referral->delete()) {
            return redirect(url('referral'))->with('success', "Successfully deleted referral information record");
        }

        return back()->with('error', 'Something went wrong');
    }
}
