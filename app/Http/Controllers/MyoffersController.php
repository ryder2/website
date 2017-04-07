<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class MyoffersController extends Controller
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
        return view('myoffers', ['offres' => $offres]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $offre = DB::table('offres')->where('id', '=', $id);
        $offre->delete();
        return redirect('myoffers');
    }

    public function add()
    {
        return view('addoffers');
    }
    public function apply(Request $request)
    {
        $id = $request->id;
        $offres = DB::table('offres')->where('id', '=', $id)->get();
        return view('applyoffer', ['offres' => $offres]);
    }

    public function applyonoffer(Request $request)
    {
        $name = $request->name;
        $offre_id = $request->offre_id;
        $montant = $request->montant;
        $sedeplace = $request->sedeplace;
        $fournitpiece = $request->fournitpiece;
        DB::table('offreapplications')->insertGetId([
            'name' => $name,
            'offre_id' => $offre_id,
            'montant' => $montant,
            'sedeplace' => $sedeplace,
            'fournitpiece' => $fournitpiece,
        ]);
        return redirect('home');
    }

    public function create(Request $request)
    {
        $username = $request->username;
        $car = $request->car;
        $city = $request->city;
        $country = $request->country;
        $title = $request->title;
        $message = $request->message;
        DB::table('offres')->insertGetId([
            'username' => $username,
            'car' => $car,
            'city' => $city,
            'country' => $country,
            'title' => $title,
            'message' => $message,
        ]);
        return redirect('myoffers');
    }
}
