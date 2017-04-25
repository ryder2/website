<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Order;
use App\Review;
use App\User;
use Mail;
use App\Mail\NewOffer;
use Carbon\Carbon;

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
        $offres = DB::table('offres')->where('username', '=', Auth::user()->name)->orderBy('created_at','desc')->get();

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

    public function completedofferapplication(Request $request)
    {
        $id = $request->id;
        $offreapplication = DB::table('offreapplications')->where('id', '=', $id)->update(['completed' => 1]);
        return redirect('home');
    }

    public function viewofferapplication(Request $request)
    {
        $id = $request->id;
        $offreapplications = DB::table('offreapplications')->where('offre_id', '=', $id)->orderBy('created_at','desc')->get();
        
        return view('viewofferapplication', ['offreapplications' => $offreapplications]);
    }

    public function add()
    {
        $jobtypes = DB::table('typetravail')->get();
        return view('addoffers', ['jobtypes' => $jobtypes]);
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
        $montant = number_format($request->totalbox, 2, '.', '');
        $sedeplace = $request->sedeplace;
        $fournitpiece = $request->fournitpiece;
        if($sedeplace) {
            $address = "";
        } else {
            $address = $request->address;
        }
        
        $offreApplicationId = DB::table('offreapplications')->insertGetId([
            'name' => $name,
            'offre_id' => $offre_id,
            'montant' => $montant,
            'sedeplace' => $sedeplace,
            'fournitpiece' => $fournitpiece,
            'address' => $address,
        ]);
        $offre = DB::table('offres')->where('id', '=', $offre_id)->first();
        $user = DB::table('users')->where('name', '=', $offre->username)->first();
        $offreapplication = DB::table('offreapplications')->where('id', '=', $offreApplicationId)->first();

        Mail::to($user->email)->send(new NewOffer($offreapplication, $offre));

        return redirect('home');
    }

    public function create(Request $request)
    {
        $username = $request->username;
        $caryears = $request->car_years;
        $carmakes = $request->car_makes_txt;
        $carmodels = $request->car_models;
        $carmodeltrims = $request->car_model_trims_txt;
        $city = $request->city;
        $country = $request->country;
        $title = $request->title;
        $message = $request->message;
        $wanteddate = $request->wanteddate;

        $car = $caryears . " " . $carmakes . " " . $carmodels . " " . $carmodeltrims . " "; 

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
            'completed' => 0,
        ]);
        return redirect('myoffers');
    }
   /**
    * Make a Stripe payment.
    *
    * @param Illuminate\Http\Request $request
    * @param App\Product $product
    * @return chargeCustomer()
    */
    public function postPayWithStripe(Request $request, $product)
    {
        $mecano = DB::table('users')->where('name', '=', $request->input('mecanoName'))->first();
        $comment = $request->input('comment');
        $rating = $request->input('rating');

        $review = new Review;

        $review->storeReviewForProduct($mecano->id, $comment, $rating);

        $offre = DB::table('offres')->where('id', '=', $request->input('offreid'))->update(['completed' => 1]);
        $product = DB::table('offreapplications')->where('id', '=', $product)->first();
        return $this->chargeCustomer($product->id, $product->montant, $product->name, $request->input('stripeToken'), $mecano);
    }
 
   /**
    * Charge a Stripe customer.
    *
    * @var Stripe\Customer $customer
    * @param integer $product_id
    * @param integer $product_price
    * @param string $product_name
    * @param string $token
    * @return createStripeCharge()
    */
    public function chargeCustomer($product_id, $product_price, $product_name, $token, $mecano)
    {
        \Stripe\Stripe::setApiKey('sk_test_oXWrbKryk4Up33w2LZTQ3gK6');
        
        if (!$this->isStripeCustomer())
        {
            $customer = $this->createStripeCustomer($token);
        }
        else
        {
            $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        }
 
        return $this->createStripeCharge($product_id, $product_price, $product_name, $customer, $mecano);
    }
 
   /**
    * Create a Stripe charge.
    *
    * @var Stripe\Charge $charge
    * @var Stripe\Error\Card $e
    * @param integer $product_id
    * @param integer $product_price
    * @param string $product_name
    * @param Stripe\Customer $customer
    * @return postStoreOrder()
    */
    public function createStripeCharge($product_id, $product_price, $product_name, $customer, $mecano)
    {
        try {
            $product_price = preg_replace('|[^0-9]|i', '', number_format($product_price, 2));
            $charge = \Stripe\Charge::create(array(
                "amount" => $product_price,
                "currency" => "CAD",
                "customer" => $customer->id,
                "destination" => $mecano->stripe_id,
                "application_fee" => $product_price * 0.5,
                "description" => $product_name
            ));
        } catch(\Stripe\Error\Card $e) {
            return redirect()
                ->route('index')
                ->with('error', 'Your credit card was been declined. Please try again or contact us.');
    }
 
        return $this->postStoreOrder($product_name);
    }
 
   /**
    * Create a new Stripe customer for a given user.
    *
    * @var Stripe\Customer $customer
    * @param string $token
    * @return Stripe\Customer $customer
    */
    public function createStripeCustomer($token)
    {
        \Stripe\Stripe::setApiKey('sk_test_oXWrbKryk4Up33w2LZTQ3gK6');
 
        $customer = \Stripe\Customer::create(array(
            "description" => Auth::user()->email,
            "source" => $token
        ));
 
        Auth::user()->stripe_id = $customer->id;
        Auth::user()->save();
 
        return $customer;
    }
 
   /**
    * Check if the Stripe customer exists.
    *
    * @return boolean
    */
    public function isStripeCustomer()
    {
        return Auth::user() && \App\User::where('id', Auth::user()->id)->whereNotNull('stripe_id')->first();
    }
 
   /**
    * Store a order.
    *
    * @param string $product_name
    * @return redirect()
    */
    public function postStoreOrder($product_name)
    {
        Order::create([
            'email' => Auth::user()->email,
            'product' => $product_name
        ]);
 
        return redirect('myoffers');
    }
}
