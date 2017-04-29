<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeController extends Controller {
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
        $offreapplications = [];
        $offres = DB::table('offres')->where([['city', '=', Auth::user()->ville], ['completed', '=', 0]])->orderBy('created_at','desc')->get();
        foreach ($offres as $offre) {
            $applications = DB::table('offreapplications')->where('offre_id', '=', $offre->id)->get();
            foreach ($applications as $application) {
                array_push($offreapplications, $application);
            }
        }
        return view('home', ['offres' => $offres, 'offreapplications' => $offreapplications]);
    }
}
