<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function updateHierarchy(Request $request)
    {
        if ($request->hasFile("file")) {
            File::delete('public/img/company-hierarchy.jpeg');

            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs('img', $request->file, 'company-hierarchy.jpeg');
        }

        return back()->with('success', "Successfully changed the Employee Hierarchy Image.");
    }

    public function updateAttendance(Request $request)
    {
        if ($request->hasFile("file")) {
            File::delete('public/attachment/attendance.pdf');

            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs('attachment', $request->file, 'attendance.pdf');
        }

        return back()->with('success', "Successfully changed the Company Policy - Attendance.");
    }

    public function updateDirectives(Request $request)
    {
        if ($request->hasFile("file")) {
            File::delete('public/attachment/directives.pdf');

            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs('attachment', $request->file, 'directives.pdf');
        }

        return back()->with('success', "Successfully changed the Company Policy - Directives.");
    }

    public function updateDresscode(Request $request)
    {
        if ($request->hasFile("file")) {
            File::delete('public/attachment/dresscode.pdf');

            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs('attachment', $request->file, 'dresscode.pdf');
        }

        return back()->with('success', "Successfully changed the Company Policy - Dress Code.");
    }
}
