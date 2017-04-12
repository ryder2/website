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
        if(Auth::user()->mecano) {
            $calenderoffers = [];
            $events = [];

            $offres = DB::table('offreapplications')->where([['name', '=', Auth::user()->name], ['accepted', '=', 1]])->get();
            foreach ($offres as $offre) {
                $calenderoffer = DB::table('offres')->where('id', '=', $offre->offre_id)->get();
                array_push($calenderoffers, $calenderoffer);
            }

            foreach ($calenderoffers as $calenderofferfinal) {
                $event = \Calendar::event(
                $calenderofferfinal[0]->title, //event title
                false, //full day event?
                $calenderofferfinal[0]->wanteddate, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $calenderofferfinal[0]->wanteddate, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                1, //optional event ID
                [
                    'url' => 'http://full-calendar.io'
                ]
            );

            array_push($events, $event);
            }

            $eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

            $calendar = \Calendar::addEvents($events); 

            return view('calender', compact('calendar'));

        } else {
            $calenderoffers = [];
            $events = [];

            $offres = DB::table('offres')->where('username', '=', Auth::user()->name)->get();
            foreach ($offres as $offre) {
                $calenderoffer = DB::table('offreapplications')->where([['offre_id', '=', $offre->id], ['accepted', '=', 1]])->get();
                foreach ($calenderoffer as $calenders) {
                    if($calenders->offre_id == $offre->id) {
                        array_push($calenderoffers, $offre); 
                    }
                }
                
            }

            foreach ($calenderoffers as $calenderofferfinal) {
                $event = \Calendar::event(
                $calenderofferfinal->title, //event title
                false, //full day event?
                $calenderofferfinal->wanteddate, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $calenderofferfinal->wanteddate, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                1, //optional event ID
                [
                    'url' => 'http://full-calendar.io'
                ]
            );

            array_push($events, $event);
            }

            $eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

            $calendar = \Calendar::addEvents($events); 

            return view('calender', compact('calendar'));
        }
    }
}
