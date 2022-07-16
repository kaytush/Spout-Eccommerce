<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin;
use App\Models\AdminLogin;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/control/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin()
    {
        return view('auth.admin.login');
    }

    /**
     * Show the application loginprocess.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            $user = auth()->guard('admin')->user();

            $admin_ip = request()->ip();
            // Use JSON encoded string and converts
            // it into a PHP variable


                $baseUrl = "http://www.geoplugin.net/";
                $endpoint = "json.gp?ip=" . $admin_ip."";
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



            $ul['admin_id'] = auth()->guard('admin')->user()->id;
            $ul['admin_ip'] =  request()->ip();
           if($city){
            $ul['location'] = ''.$conti.', '.$country.' , '.$city.'';
            }
            else{
            $ul['location'] = 'Unknown';
            }
         $ul['details'] = $_SERVER['HTTP_USER_AGENT'];
            AdminLogin::create($ul);

            // \Session::put('success','You are Login successfully!!');
            return redirect()->route('admin.dashboard')->with('success','You are Login successfully!!');

        } else {
            return back()->with('error','your username and password are wrong.');
        }

    }

    /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->guard('admin')->logout();
        // Session::flush();
        // Sessioin::put('success','You are logout successfully');
        return redirect(route('adminLogin'))->with('success', 'Log out successfully');
    }
}
