<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
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
        $data['page_title'] = "Sign In";
        $setting = GeneralSettings::first();
        $login = $setting->login;
        if($login == 1){
            return view('theme.'.$this->theme.'.auth.login', $data);
        }
        else {
            return redirect()->route('main')->with(["info"=>"Login temporary Disabled"]);
        }
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if(is_numeric($request->input('email'))){
            $login_type = 'phone';
        } elseif (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            $login_type = 'email';
        } else {
            $login_type = 'username';
        }

        $request->merge([
            $login_type => $request->input('email')
        ]);

        $request->authenticate($login_type);

        $request->session()->regenerate();

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



        $ul['user_id'] = auth()->user()->id;
        $ul['user_ip'] =  request()->ip();
        if($city){
            $ul['location'] = ''.$conti.', '.$country.' , '.$city.'';
        }
        else{
            $ul['location'] = 'Unknown';
        }
        $ul['details'] = $_SERVER['HTTP_USER_AGENT'];
        UserLogin::create($ul);

        if(env('VIRTUAL_ACC') == 'budpay'){
            if(auth()->user()->bp_customer_code == NULL){
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
                    CURLOPT_POSTFIELDS => '{"email": "' . auth()->user()->email . '","first_name": "' . auth()->user()->firstname . '","last_name": "' . auth()->user()->lastname . '","phone": "' . auth()->user()->phone . '"}',
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
                    $bpc = User::findOrFail(auth()->user()->id);
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
            }
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
