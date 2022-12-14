<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.index');
    }

    public function create()
    {
        return view('survey.create');
    }
}