<?php

namespace App\Http\Controllers\Auth;

use DB;
use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/myprofile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'rue' => 'required|max:255',
            'codepostal' => 'required|max:255',
            'ville' => 'required|max:255',
            'province' => 'required|max:255',
            'pays' => 'required|max:255',
            'TermsAndConditions' => 'accepted',
            'dobyear' => 'required',
            'dobmonth' => 'required',
            'dobday' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'rue' => $data['rue'],
            'codepostal' => $data['codepostal'],
            'ville' => $data['ville'],
            'province' => $data['province'],
            'pays' => $data['pays'],
            'mecano' => $data['mecano'],
            'dobyear' => $data['dobyear'],
            'dobmonth' => $data['dobmonth'],
            'dobday' => $data['dobday'],
            'email_token' => str_random(10),
        ]);
    }


/**
*  Over-ridden the register method from the "RegistersUsers" trait
*  Remember to take care while upgrading laravel
*/
    public function register(Request $request)
    {
        // Laravel validation
        $validator = $this->validator($request->all());
        if ($validator->fails()) 
        {
            $this->throwValidationException($request, $validator);
        }
        // Using database transactions is useful here because stuff happening is actually a transaction
        // I don't know what I said in the last line! Weird!
        DB::beginTransaction();
        try
        {
            $user = $this->create($request->all());
            // After creating the user send an email with the random token generated in the create method above
            $email = new EmailVerification(new User(['email_token' => $user->email_token, 'name' => $user->name]));
            Mail::to($user->email)->send($email);
            DB::commit();
            return redirect('/login')->with('status', 'We sent you an activation code. Check your email.');;
        }
        catch(Exception $e)
        {
            DB::rollback(); 
            return back();
        }
    }

    public function verify($token)
    {
        // The verified method has been added to the user model and chained here
        // for better readability
        User::where('email_token',$token)->firstOrFail()->verified();
        return redirect('login');
        }
}
