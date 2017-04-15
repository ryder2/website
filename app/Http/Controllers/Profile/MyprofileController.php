<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Review;
use App\User;
use Image;

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
        $id = Auth::user()->id;
        $product = User::find($id);
        // Get all reviews that are not spam for the product and paginate them
        $reviews = $product->reviews()->approved()->notSpam()->orderBy('created_at','desc')->paginate(100);

        return view('profile\view', ['reviews' => $reviews]);
    }


    public function ratemecano(Request $request)
    {

        $mecano = DB::table('users')->where('name', '=', $request->input('mecanoName'))->first();
        $comment = $request->input('comment');
        $rating = $request->input('rating');

        $review = new Review;

        $review->storeReviewForProduct($mecano->id, $comment, $rating);

        $offre = DB::table('offres')->where('id', '=', $request->input('offreid'))->update(['completed' => 1]);

        return redirect('myoffers');
    }
    public function edit()
    {
        return view('profile\edit');
    }
    protected function save(Request $request)
    {   
        $user = Auth::user();
        if($request->file()){
            if(count($request->file('cartemecano')))
            {
                $image = $request->file('cartemecano');
                $filename  = time() . '.' . $image->getClientOriginalExtension();

                $path = public_path('/storage/users/cpacard/' . $filename);
     
                Image::make($image->getRealPath())->resize(200, 100)->save($path);
                $user->cartemecano = 'storage/users/cpacard/' . $filename;
            }
            if(count($request->file('profileimg')))
            {
                $image = $request->file('profileimg');
                $filename  = time() . '.' . $image->getClientOriginalExtension();

                $path = public_path('/storage/users/profile/' . $filename);
     
                Image::make($image->getRealPath())->resize(150, 200)->save($path);
                $user->avatar = 'storage/users/profile/' . $filename;
            }

        }

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