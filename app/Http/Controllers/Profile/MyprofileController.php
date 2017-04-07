<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class MyprofileController extends Controller
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
        return view('profile\view');
    }
    public function edit()
    {
        return view('profile\edit');
    }
    protected function save(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->rue = $request->input('rue');
        $user->codepostal = $request->input('codepostal');
        $user->ville = $request->input('ville');
        $user->province = $request->input('province');
        $user->pays = $request->input('pays');

        $user->apropos = $request->input('apropos');

        $user->experience = $request->input('experience');

        $user->save();
        return redirect('myprofile');
    }
}