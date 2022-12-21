<?php

namespace App\Http\Controllers;

use App\Mail\ReferralSubmitted;
use App\User;
use App\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Valuestore\Valuestore;

class ReferralController extends Controller
{
    public $settings;

    public function __construct()
    {
        $this->settings = Valuestore::make(storage_path('app/settings.json'));
    }

    public function index()
    {
        $data['referrals'] = Referral::all();

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

        if($referral->save()){
            if($this->settings->get('email_notification')){
                $erp = User::where('is_erp', '=', 1)->orWhere('is_admin', '=', 1)->select('email')->get()->toArray();
                if(count($erp) > 0){
                    Mail::to($erp)->queue(new ReferralSubmitted($referral));
                }
            }

            return back()->with('success', 'Referral successfully sent to the ERP Team. Thank you.');
        }

        return back()->with('error', 'Something went wrong');
    }

    public function show($id)
    {
        $data['referral'] = Referral::find($id);

        return view('referral.show', $data);
    }
}
