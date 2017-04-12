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
        $offreapplications = [];
        $offres = DB::table('offres')->where('username', '=', Auth::user()->name)->get();

        foreach ($offres as $offre) {
            $applications = DB::table('offreapplications')->where('offre_id', '=', $offre->id)->get();
            foreach ($applications as $application) {
                array_push($offreapplications, $application);
            }
        }
        return view('myoffers', ['offres' => $offres, 'offreapplications' => $offreapplications]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $offre = DB::table('offres')->where('id', '=', $id);
        $offre->delete();
        return redirect('myoffers');
    }

    public function deleteofferapplication(Request $request)
    {
        $id = $request->idapplication;
        $offreapplication = DB::table('offreapplications')->where('id', '=', $id);
        $offreapplication->delete();
        return redirect('home');
    }

    public function viewofferapplication(Request $request)
    {
        $id = $request->id;
        $offreapplications = DB::table('offreapplications')->where('offre_id', '=', $id)->get();
        
        return view('viewofferapplication', ['offreapplications' => $offreapplications]);
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
        public function acceptofferapplication(Request $request)
    {
        $id = $request->id;
        $address = $request->address;
        if($address) {
            $offre = DB::table('offreapplications')->where('id', '=', $id)->update(['accepted' => 1, 'address' => $address]); 
        } else {
            $offre = DB::table('offreapplications')->where('id', '=', $id)->update(['accepted' => 1]); 
        }
        
        return redirect('myoffers');
    }

    public function applyonoffer(Request $request)
    {
        $name = $request->name;
        $offre_id = $request->offre_id;
        $montant = $request->montant;
        $sedeplace = $request->sedeplace;
        $fournitpiece = $request->fournitpiece;
        $address = $request->address;
        DB::table('offreapplications')->insertGetId([
            'name' => $name,
            'offre_id' => $offre_id,
            'montant' => $montant,
            'sedeplace' => $sedeplace,
            'fournitpiece' => $fournitpiece,
            'address' => $address,
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
        $wanteddate = $request->wanteddate;

        $quoted = preg_quote('!*\'();:@&=+$,/?%#[]','/');
        $sanitized = preg_replace('/['.$quoted.']/', '', $wanteddate);

        DB::table('offres')->insertGetId([
            'username' => $username,
            'car' => $car,
            'city' => $city,
            'country' => $country,
            'title' => $title,
            'message' => $message,
            'wanteddate' => $sanitized,
        ]);
        return redirect('myoffers');
    }
}
