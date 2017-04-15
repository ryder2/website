<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Review;
use App\User;


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

        $id = $mecano->id;
        $product = User::find($id);
        // Get all reviews that are not spam for the product and paginate them
        $reviews = $product->reviews()->approved()->notSpam()->orderBy('created_at','desc')->paginate(100);

       	return view('seemecanoprofile', ['mecano' => $mecano], ['reviews' => $reviews]);
    }
}