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

    public function switchInfo($user_id){
        
        $product = User::find($user_id);
        // Get all reviews that are not spam for the product and paginate them
        $reviews = $product->reviews()->approved()->notSpam()->orderBy('created_at','desc')->paginate(100);

       	return view('seemecanoprofile', ['mecano' => $product], ['reviews' => $reviews]);
    }
}