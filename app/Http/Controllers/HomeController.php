<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeController extends Controller
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
        $offreapplications = DB::table('offreapplications')->get();
        $offres = DB::table('offres')->where([['city', '=', Auth::user()->ville], ['completed', '=', 0]])->get();
        return view('home', ['offres' => $offres, 'offreapplications' => $offreapplications]);
    }
}
