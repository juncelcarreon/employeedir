<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\User;
use App\ElinkActivities;
use App\EmployeeDepartment;
use App\Posts;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check() && Auth::user()->isAdmin()) {
            return redirect('dashboard');
        }

        $data['posts'] = Posts::where('enabled', '=', '1')->get();
        $data['new_hires'] = User::allExceptSuperAdmin()->orderBy('prod_date', 'DESC')->paginate(5);
        $data['employees'] = User::allExceptSuperAdmin()->get();
        $data['birthdays'] = User::whereRaw('MONTH(birth_date) = '.date('n'))->whereRaw('deleted_at is null')->where("status","=",1)->orderByRaw('DAYOFMONTH(birth_date) ASC')->get();
        $data['engagements'] = ElinkActivities::getActivities();
        $data['dashboard'] = 0;

        return view('home', $data);
    }

    public function dashboard(Request $request)
    {
        $data['posts'] = Posts::where('enabled', '=', '1')->get();
        $data['new_hires'] = User::allExceptSuperAdmin()->orderBy('prod_date', 'DESC')->paginate(5);
        $data['employees'] = User::allExceptSuperAdmin()->get();
        $data['birthdays'] = User::whereRaw('MONTH(birth_date) = '.date('n'))->whereRaw('deleted_at is null')->where("status","=",1)->orderByRaw('DAYOFMONTH(birth_date) ASC')->get();
        $data['engagements'] = ElinkActivities::getActivities();
        $data['dashboard'] = 1;

        return view('home', $data);
    }

    public function newhires(Request $request)
    {
        return User::allExceptSuperAdmin()->orderBy('prod_date', 'DESC')->paginate(5);
    }
} 
