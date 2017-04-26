<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Image;

class BankAccountManagingController extends Controller
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
    public function index(Request $request)
    {
      
        if($request->file()){
            if(count($request->file('idimg')))
            {
                $image = $request->file('idimg');
                $filename  = time() . '.' . $image->getClientOriginalExtension();

                $path = public_path('/storage/users/ids/' . $filename);
     
                Image::make($image->getRealPath())->resize(200, 100)->save($path);
            }
        }
        $name = explode(" ", Auth::user()->name);

        \Stripe\Stripe::setApiKey("sk_test_oXWrbKryk4Up33w2LZTQ3gK6");
        try {
          $newAccount = \Stripe\Account::create(
            array(
              "country" => $request->country,
              "email" => Auth::user()->email,
              "managed" => true,
              "external_account" => $request->stripeToken,
              "legal_entity" => array(
                                "personal_id_number" => $request->idnumber,
                                "dob" => array(
                                        "day" => Auth::user()->dobday,
                                        "month" => Auth::user()->dobmonth,
                                        "year" => Auth::user()->dobyear
                                        ),
                                "first_name" => $name[0],
                                "last_name" => $name[1],
                                "type" => $request->account_holder_type,
                                "address" => array(
                                            "city" => Auth::user()->ville,
                                            "line1" => Auth::user()->rue,
                                            "postal_code" => Auth::user()->codepostal,
                                            "state" => Auth::user()->province
                                            )
                                ),
              "tos_acceptance" => array(
                                  "date" => time(),
                                  "ip" => $request->ip()
                                  )
            )
          );

        $imgid = \Stripe\FileUpload::create(
          array(
            "purpose" => "identity_document",
            "file" => fopen($path, 'r')
          ),
          array("stripe_account" => $newAccount->id)
        );

        $account = \Stripe\Account::retrieve($newAccount->id);
        $account->legal_entity->verification->document = $imgid->id;
        $account->save();

        Auth::user()->stripe_id = $newAccount->id;
        Auth::user()->save();
        return redirect('myprofile');

      } catch (\Stripe\Error\Base $e) {
            // Code to do something with the $e exception object when an error occurs
          return back()->with('warning',$e->getMessage());
      }
    }

    public function modify(Request $request)
    {
      
        if($request->file()){
            if(count($request->file('idimg')))
            {
                $image = $request->file('idimg');
                $filename  = time() . '.' . $image->getClientOriginalExtension();

                $path = public_path('/storage/users/ids/' . $filename);
     
                Image::make($image->getRealPath())->resize(200, 100)->save($path);
            }
        }
        $name = explode(" ", Auth::user()->name);

        \Stripe\Stripe::setApiKey("sk_test_oXWrbKryk4Up33w2LZTQ3gK6");

        $imgid = \Stripe\FileUpload::create(
          array(
            "purpose" => "identity_document",
            "file" => fopen($path, 'r')
          ),
          array("stripe_account" =>Auth::user()->stripe_id)
        );  

        try {
        $account = \Stripe\Account::retrieve(Auth::user()->stripe_id);
        $account->email = Auth::user()->email;
        $account->external_account = $request->stripeToken;
        $account->legal_entity->verification->document = $imgid->id;
        $account->legal_entity->dob->day = Auth::user()->dobday;
        $account->legal_entity->dob->month = Auth::user()->dobmonth;
        $account->legal_entity->dob->year = Auth::user()->dobyear;
        $account->legal_entity->type = $request->account_holder_type;
        $account->legal_entity->address->city = Auth::user()->ville;
        $account->legal_entity->address->line1 = Auth::user()->rue;
        $account->legal_entity->address->postal_code = Auth::user()->codepostal;
        $account->legal_entity->address->state = Auth::user()->province;
        $account->tos_acceptance->date = time();
        $account->tos_acceptance->ip = $request->ip();
        $account->save();
        return redirect('myprofile');

      } catch (\Stripe\Error\Base $e) {
            // Code to do something with the $e exception object when an error occurs
          return back()->with('warning',$e->getMessage());
      }
    }
}
