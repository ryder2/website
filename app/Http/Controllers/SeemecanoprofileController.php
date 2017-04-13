<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


class SeemecanoprofileController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function switchInfo($name){
    	$mecano = DB::table('users')->where('name', '=', $name)->first();
       	return view('seemecanoprofile', ['mecano' => $mecano]);
    }
}