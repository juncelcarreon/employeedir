<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 

class HierarchyController extends Controller
{
    public function hierarchy(){
        return view('employee.hierarchy');
    }

    public function updateHierarchy(Request $request){
        if ($request->hasFile("file")) {
            File::delete('public/img/company-hierarchy.jpeg');

            $extension = $request->file('file')->guessExtension();
            $path = Storage::disk('public')->putFileAs('img', $request->file, 'company-hierarchy.jpeg');
        }

        return back()->with('success', "Successfully changed the employee hierarchy image.");
    }
}
