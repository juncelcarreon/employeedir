<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events;

class EventsController extends Controller
{
    public function index()
    {
        $data['events'] = Events::all();

        return view('events.index', $data);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $events = new Events();
        $events->event_name = $request->event_name;
        $events->event_description = $request->event_description;
        $events->event_color = $request->event_color;
        if($request->has('start_date')){
            $events->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
        }

        if($request->has('end_date')){
            $events->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
        }

        if($events->save()){
            return redirect(url("events/{$events->id}"))->with('success', 'Event successfully added!');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function show($id)
    {
        $data['event'] = Events::find($id);

        return view('events.view', $data);
    }

    public function edit($id)
    {
        $data['event'] = Events::find($id);

        return view('events.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $event = Events::find($id);
        $event->event_name = $request->event_name;
        $event->event_description = $request->event_description;
        $event->event_color = $request->event_color;
        if($request->has('start_date')){
            $event->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
        }
        if($request->has('end_date')){
            $event->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
        }

        if($event->save()){
            return redirect('events/' . $event->id)->with('success', 'Succesfully updated the event details');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function destroy($id)
    {
        $event = Events::find($id);
        if($event->delete()){
            return redirect('events')->with('success', 'Succesfully deleted the event');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function calendar()
    {
        return view('events.calendar');
    }

    public function lists()
    {
        return Events::all();
    }
}
