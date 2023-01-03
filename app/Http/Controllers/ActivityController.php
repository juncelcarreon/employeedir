<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ElinkActivities;
use DateTime;

class ActivityController extends Controller
{
    public function index()
    {
        $data['activities'] = ElinkActivities::all();

        return view('activity.list', $data);
    }

    public function create()
    {
        return view('activity.create');
    }

    public function store(Request $request)
    {
        $activity = new ElinkActivities;
        $activity->title = $request->title;
        $activity->subtitle = $request->subtitle;
        $activity->message = $request->message;

        $datetime = new DateTime();
        if ($request->has('activity_date') && $request->activity_date) {
            $activity_date = $datetime->createFromFormat('m/d/Y', $request->activity_date)->format("Y-m-d H:i:s");
            $activity->activity_date = $activity_date;
        }

        $activity->save();

        if ($request->hasFile("image_url")) {
            $path = $request->image_url->store('images/'.$activity->id);
            $activity->image_url =  asset('storage/app/'.$path);
            $activity->save();
        }

        return redirect()->back()->with('success', "Successfully added an activity");
    }

    public function show($id)
    {
        return redirect(url('404'));
    }

    public function edit($id)
    {
        $activity = ElinkActivities::find($id);
        if(empty($activity)){
            return redirect(url('404'));
        }

        $data['activity'] = $activity;

        return view('activity.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $activity = ElinkActivities::find($id);
        $activity->title = $request->title;
        $activity->subtitle = $request->subtitle;
        $activity->message = $request->message;

        $datetime = new DateTime();
        if ($request->has('activity_date') && $request->activity_date) {
            $activity_date = $datetime->createFromFormat('m/d/Y', $request->activity_date)->format("Y-m-d H:i:s");
            $activity->activity_date = $activity_date;
        }

        $activity->save();

        if ($request->hasFile("image_url")) {
            $path = $request->image_url->store('images/'.$activity->id);
            $activity->image_url =  asset('storage/app/'.$path);
            $activity->save();
        }

        return redirect()->back()->with('success', "Successfully edited an activity");
    }

    public function destroy($id)
    {
        $activity = ElinkActivities::find($id);
        $activity->delete();

        return redirect()->back()->with('success', "Successfully deleted activity record");
    }
}
