<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\GeneralSettings;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    private $theme;

    public function __construct()
    {
        $this->theme = GeneralSettings::first()->theme; // theme name
    }
    public function create()
    {
        $data['page_title'] = "Sign Up";
        $setting = GeneralSettings::first();
        $registration = $setting->registration;
        $login = $setting->login;
        if($registration == 1){
            return view('theme.'.$this->theme.'.auth.register', $data);
        }
        else {
            if ($login == 1) {
                return redirect()->route('login')->with(["info"=>"User Registration is temporary Unavailable"]);
            }
            else {
            return redirect()->route('main')->with(["info"=>"Registration temporary Disabled"]);
            }
        }
    }

    //view reg form using referral link
    public function createwithref($ref)
    {
        $setting = GeneralSettings::first();
        $registration = $setting->registration;
        $login = $setting->login;
        if($registration == 1){
            $refuser = User::where('username',$ref)->first();
            if(!$refuser){
                return redirect()->route('register')->with(["error"=>"Referral Link/Code ".$ref." do not exist"]);
            }
            session()->put('referral', $ref);
            return view('theme.'.$this->theme.'.auth.register', compact('ref'));

        }
        else {
            if ($login == 1) {
                return redirect()->route('login')->with(["info"=>"Registration temporary off"]);
            }
            else {
            return redirect()->route('main')->with(["info"=>"Registration temporary Disabled"]);
            }
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|numeric|min:11|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Log Registration Attempt
        Log::info("New User Registration Attempt - ".json_encode($request->all()));

        $setting = GeneralSettings::first();
        if ($setting->email_verification == 1) {
            $email_verified = 0;
        } else {
            $email_verified = 1;
        }

        //find referral
        $ref = User::where('username', $request->referral)->first();
        if(!$ref){
            $referral = NULL;
        }else{
            $referral = $request->referral;
        }

        $email_code  = random_int(0000, 9999);
        // return $email_code;

        Auth::login($user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'referral' => $referral,
            'email_verified' => $email_verified,
            'email_code' => $email_code,
        ]));

        Log::notice("New User Registration Successful - for User with Email: ".$user->email);

        if ($setting->email_verification == 1) {
            $email_code = $user->email_code;
            $text = "Your Verification Code Is: <b>$email_code</b>";
            send_email_verification($user->email, $user->firstname, 'Email Verification', $text);

            Log::notice("Email Verification Sent for Registration - User Email: ".$user->email." - VERIRICATION CODE: ".$email_code);
        }

        $user_ip = request()->ip();
            // Use JSON encoded string and converts
            // it into a PHP variable


                $baseUrl = "http://www.geoplugin.net/";
                $endpoint = "json.gp?ip=" . $user_ip."";
                $httpVerb = "GET";
                $contentType = "application/json"; //e.g charset=utf-8
                $headers = array (
                    "Content-Type: $contentType",

                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, $baseUrl.$endpoint);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $content = json_decode(curl_exec( $ch ),true);
                $err     = curl_errno( $ch );
                $errmsg  = curl_error( $ch );
                curl_close($ch);


                 $conti = $content['geoplugin_continentName'];
                 $country = $content['geoplugin_countryName'];
                 $city = $content['geoplugin_city'];



            $ul['user_id'] = $user->id;
            $ul['user_ip'] =  request()->ip();
           if($city){
            $ul['location'] = ''.$conti.', '.$country.' , '.$city.'';
            }
            else{
            $ul['location'] = 'Unknown';
            }
            $ul['details'] = $_SERVER['HTTP_USER_AGENT'];
            UserLogin::create($ul);

            //Create Budpay Customer
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('BUD_URL') . "customer",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"email": "' . $user->email . '","first_name": "' . $user->firstname . '","last_name": "' . $user->lastname . '","phone": "' . $user->phone . '"}',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . env('BUD_SK_KEY'),
                    'Content-Type: application/json'
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response, true);

            Log::notice("New Customer Code generated successfully".json_encode($res));

            if ($res['status'] == true){
                $bpc = User::findOrFail($user->id);
                $bpc->bp_customer_id = $res['data']['id'];
                $bpc->bp_customer_code = $res['data']['customer_code'];
                $bpc->save();

                //Create Budpay Account for Customer
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => env('BUD_URL') . "dedicated_virtual_account",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{"customer": "' . $res['data']['customer_code'] . '"}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . env('BUD_SK_KEY'),
                        'Content-Type: application/json'
                    ),
                ));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($curl);

                curl_close($curl);

                $res = json_decode($response, true);

                Log::notice("Customer Account created successfully".json_encode($res));

                if ($res['status'] == true){
                    $bpc->bank_name = $res['data']['bank']['name'];
                    $bpc->account_name = $res['data']['account_name'];
                    $bpc->account_number = $res['data']['account_number'];
                    $bpc->save();
                }
            }

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
