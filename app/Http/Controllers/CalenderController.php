<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\EventModel;
use MaddHatter\LaravelFullcalendar\Event;

class CalenderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offres = DB::table('offres')->where('username', '=', Auth::user()->name)->get();
        $events = [];
        $event = \Calendar::event(
            "Valentine's Day", //event title
            true, //full day event?
            '2017-04-07', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
            '2017-04-08', //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
            1, //optional event ID
            [
                'url' => 'http://full-calendar.io'
            ]
        );

        array_push($events, $event);

        $eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

        $calendar = \Calendar::addEvents($events); 

        return view('calender', compact('calendar'));
    }
}
