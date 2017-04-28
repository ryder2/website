<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class AdminpanelController extends Controller
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
        if(Auth::user()->role_id == 1) {
            $users = DB::table('users')->orderBy('created_at','desc')->get();
            return view('adminpanel', ['users' => $users]);
        }
        return view('myprofile');
    }

    public function search(Request $keyword)
    {
        if (strlen($keyword->keywords) > 0) {
            $searchUsers = DB::table('users')->where("name", "like", '%' . $keyword->keywords . '%')->orderBy('created_at','desc')->get();
        } else {
            $searchUsers = DB::table('users')->orderBy('created_at','desc')->get();
        }
        
        return view('searchUsers', ['searchUsers' => $searchUsers]);
    }

    public function save(Request $request)
    {
        $id = $request->userid;
        $options = $request->selectpicker;

            if(in_array("Mecano", $options)) {
                $offre = DB::table('users')->where('id', '=', $id)->update(['mecano' => 1]);
            } else {
                $offre = DB::table('users')->where('id', '=', $id)->update(['mecano' => 0]);
            }
            if(in_array("Approuved", $options)) {
                $offre = DB::table('users')->where('id', '=', $id)->update(['approuved' => 1]);
            } else {
                $offre = DB::table('users')->where('id', '=', $id)->update(['approuved' => 0]);
            }
            if(in_array("Admin", $options)) {
                $offre = DB::table('users')->where('id', '=', $id)->update(['role_id' => 1]);
            } else {
                $offre = DB::table('users')->where('id', '=', $id)->update(['role_id' => 0]);
            }
        return redirect()->action('AdminpanelController@index');
    }
}
