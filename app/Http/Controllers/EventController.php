<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\event;
use App\EventCategory;
use Session;
use Auth;
use Validator;

use Calendar;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
    }

    public function ajaxget(){

        $ev = event::select('id as id', 'event_name as title', 'event_start as start', 'event_finish as end')->where('user_id', Auth::user()->id)->get();
        // Return as json
        return response()->json($ev);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = EventCategory::all();
        $event = event::all();
        return view('events.event', ['category' => $category, 'event' => $event]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'event_name' => 'required|string|min:2|max:255',
            'daterange' => 'required',
        ]);
        $time_start = $request->input('start_time');

        $time_end = $request->input('end_time');

        $tempDate = $request->input('daterange');
        $temp2 = str_replace('-', null, $tempDate);
        $temp2 = str_replace('/', '-', $temp2);
        $temp3 = explode('  ', $temp2);
        
        $date1 = date_create_from_format('m-d-Y', $temp3[0]);
        $date2 = date_create_from_format('m-d-Y', $temp3[1]);

        $event = new event([
            'event_name' => $request->input('event_name'),
            'event_start' => date_format($date1, 'Y-m-d'),
            'event_finish' => date_format($date2, 'Y-m-d'),
            'evcat_id' => $request->input('evcat_id'),
            'user_id' => $request->input('user_id'),
        ]);
        $event->save();
        Session::flash('success', 'Event Created Successfully');
        return redirect()->route('event.sched');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ev = event::find($id);

        $ev->event_name = $request->input("event_name");

        $ev->save();

        Session::flash('success', 'Event successfully updated.');

        return redirect()->route('event.sched');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
