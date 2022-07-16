<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    private $theme;

    public function __construct()
    {
        $this->theme = GeneralSettings::first()->theme; // theme name
    }

    //User dashboard & New Service List for Order
    public function dashboard(){
        $data['page_title'] = "Dashboard";
        $data['timenow'] = Carbon::now();
        $data['general'] = GeneralSettings::first();
        $data['trxs'] = Transaction::where('user_id',auth()->user()->id)->latest()->take(6)->get();
        return view('theme.'.$this->theme.'.dashboard', $data);
    }

    //check for maintenance mode
    public function maintain(){
        $basic = GeneralSettings::first();
        if($basic->maintain == 1){
        return view('check.maintain');
        }
    }

    // Check Status Middleware Verification related
    public function inactive(){
        return view('check.inactive');
    }

    public function authCheck(){
        $basic = GeneralSettings::first();
        if($basic->maintain == 1){
        return view('check.maintain');
        }

        if(!auth()->user()){
            return redirect()->route('login');
        }

        if (auth()->user()->status == 1 && auth()->user()->email_verified == 1) {
            return redirect()->route('dashboard');
        } else {
            return view('check.authorization');
        }
    }

    public function sendEmailVcode(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $code = strtoupper(Str::random(6));
        $user->email_code = $code;
        $user->save();
        send_email($user->email, $user->name, 'Verificatin Code', 'Your Verification Code is ' . $code);

        return back()->with(["success"=>"Verification Code Send successfully"]);

    }

    public function postEmailVerify(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->email_code == $request->email_code) {
            $user->email_verified = 1;
            $user->save();
            return redirect()->route('dashboard')->with(["success"=>"Your Profile has been verfied successfully"]);
        } else {
             return back()->withErrors('Verification Code Did not matched');
        }
        return back()->withErrors('Verification Code Did not matched');
    }

    // Transaction Logs
    public function transactions(){
        $data['page_title'] = "Transactions";
        $data['trxs'] = Transaction::where('user_id',Auth::user()->id)->paginate(20);
        return view('theme.'.$this->theme.'.logs.transactions', $data);
    }

    // Generate Wallet Address
    public function generateAddress($coin){
        $data['timenow'] = Carbon::now();
        $data['general'] = GeneralSettings::first();
            //Enter Log
            Log::notice("Attempt generating ".$coin." wallet address for User: ".auth()->user()->name  . " [User Email: ".auth()->user()->email."]");
        //generate tron address
        if($coin == "BNB"){
            $bnb_password  = Str::random(13);
            // generate BNB address
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('CHAINGATEWAY_BNB_URL') . "newAddress",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"password": "' . $bnb_password . '", "apikey": "' . env('CHAINGATEWAY_KEY') . '"}',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . env('CHAINGATEWAY_KEY'),
                    'Content-Type: application/json'
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response, true);
            //Enter Log
            Log::notice(json_encode($res)  . " - for [UserEmail: ".auth()->user()->email."] generate BNB wallet request");

            if ($res['ok'] == true){
                $u=User::find(auth()->user()->id);
                $u->bnb_wallet = $res['binancecoinaddress'];
                $u->bnb_password = $res['password'];
                $u->save();
                //Enter Log
                Log::notice("[UserEmail: ".auth()->user()->email."] - generated wallet data saved successfully");

                //subscribe to tron address
                //Enter Log
                Log::notice("[UserEmail: ".auth()->user()->email."] - attempting generated wallet IPN subscription");

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => env('CHAINGATEWAY_BNB_URL') . "subscribeAddress",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{"apikey": "' . env('CHAINGATEWAY_KEY') . '", "binancecoinaddress": "' . $u->bnb_wallet . '", "contractaddress": "' . env('CHAINGATEWAY_BEP20_CONTRACT_ADDRESS') . '", "url": "' . env('APP_URL') . 'api/secure-binance-ipn"}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . env('CHAINGATEWAY_KEY'),
                        'Content-Type: application/json'
                    ),
                ));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($curl);

                curl_close($curl);

                $res = json_decode($response, true);
                //Enter Log
                Log::notice(json_encode($res)  . " - for [UserEmail: ".auth()->user()->email."] generate BNB wallet IPN subscription");
                if ($res['ok'] == true && $res['binancecoinaddress'] == $u->bnb_wallet){
                    $u=User::find(auth()->user()->id);
                    $u->bnb_ipn_sub = 1;
                    $u->save();
                    //Enter Log
                    Log::alert("[UserEmail: ".auth()->user()->email."] - updated BNB IPN status to 1 successfully");
                }
                return redirect()->route('wallet', 'BNB')->with(["success"=>"BUSD(BEP20) Deposit Wallet Address Generated"]);
            }else{
                return back()->with(["alert"=>"Unable to generate BUSD(BEP20) Deposit Wallet Address at the moment"]);
            }

        }elseif($coin == "TRX"){
            // generate trx address
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('CHAINGATEWAY_TRX_URL') . "newAddress",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"apikey": "' . env('CHAINGATEWAY_KEY') . '"}',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . env('CHAINGATEWAY_KEY'),
                    'Content-Type: application/json'
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response, true);
            //Enter Log
            Log::notice(json_encode($res)  . " - for [UserEmail: ".auth()->user()->email."] generate wallet request");

            if ($res['ok'] == true){
                $u=User::find(auth()->user()->id);
                $u->trx_wallet = $res['address'];
                $u->trx_privatekey = $res['privatekey'];
                $u->trx_hexaddress = $res['hexaddress'];
                $u->save();
                //Enter Log
                Log::notice("[UserEmail: ".auth()->user()->email."] - generated wallet data saved successfully");

                //subscribe to tron address
                //Enter Log
                Log::notice("[UserEmail: ".auth()->user()->email."] - attempting generated TRX wallet IPN subscription");

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => env('CHAINGATEWAY_TRX_URL') . "subscribeAddress",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{"apikey": "' . env('CHAINGATEWAY_KEY') . '","tronaddress": "' . $u->trx_wallet . '","contractaddress": "' . env('CHAINGATEWAY_TRC20_CONTRACT_ADDRESS') . '", "url": "' . env('APP_URL') . 'api/secure-tron-ipn"}',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . env('CHAINGATEWAY_KEY'),
                        'Content-Type: application/json'
                    ),
                ));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($curl);

                curl_close($curl);

                $res = json_decode($response, true);
                //Enter Log
                Log::notice(json_encode($res)  . " - for [UserEmail: ".auth()->user()->email."] generate wallet TRX IPN subscription");
                if ($res['ok'] == true && $res['tronaddress'] == $u->trx_wallet){
                    $u=User::find(auth()->user()->id);
                    $u->trx_ipn_sub = 1;
                    $u->save();
                    //Enter Log
                    Log::alert("[UserEmail: ".auth()->user()->email."] - updated IPN status to 1 successfully");
                }
                return redirect()->route('wallet', 'TRX')->with(["success"=>"USDT(TRC20) Deposit Wallet Address Generated"]);
            }else{
                return back()->with(["alert"=>"Unable to generate USDT(TRC20) Deposit Wallet Address at the moment"]);
            }
        }
    }

    // wallets
    public function wallet($coin){
        if($coin == "BNB"){
            $data['wallet'] = "BUSD (BEP20)";
            $varb = "bnb:" . auth()->user()->bnb_wallet;
        }elseif($coin == "TRX"){
            $data['wallet'] = "USDT (TRC20)";
            $varb = "tron:" . auth()->user()->trx_wallet;
        }
        $data['address'] = $varb;
        $data['qrcode'] = "<img src=\"https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:250px;' />";

        return view('wallet', $data);
    }

    // Current Presale
    public function presale(){
        $data['timenow'] = Carbon::now();
        $data['general'] = GeneralSettings::first();
        $data['presale'] = Presale::where('start_time','<', $data['timenow'])->where('end_time','>', $data['timenow'])->where('status',1)->first();
        if(!$data['presale']){
            return redirect()->route('dashboard')->with(['error'=>"This Presale is not available at the moment, Try again later"]);
        }
        $view = $data['presale'];
        $view->views += 1;
        $view->save();
        $data['sold'] = Deposit::where(['presale_id'=>$data['presale']->id])->sum('amount');
        $data['recent'] = Deposit::where(['presale_id'=>$data['presale']->id])->latest()->take(5)->get();
        return view('presale', $data);
    }

    // View a Presale
    public function viewPresale($slug){
        $data['timenow'] = Carbon::now();
        $data['general'] = GeneralSettings::first();
        $data['presale'] = Presale::where(['slug'=>$slug])->first();
        if(!$data['presale']){
            return redirect()->route('dashboard')->with(['error'=>"This Presale is not available at the moment, Try again later"]);
        }
        $view = $data['presale'];
        $view->views += 1;
        $view->save();
        $data['sold'] = Deposit::where(['presale_id'=>$data['presale']->id])->sum('amount');
        $data['recent'] = Deposit::where(['presale_id'=>$data['presale']->id])->latest()->take(5)->get();
        return view('presale', $data);
    }

    // Like a Presale
    public function likes($id){
        $likes = Presale::where(['id'=>$id])->first();
        $likes->likes += 1;
        $likes->save();
        $data = $likes->likes;
        return response()->json($data, 200);
    }

    // Profile Settings
    public function profileSettings(){
        $data['general'] = GeneralSettings::first();
        return view('profile-settings', $data);
    }

    // Profile Settings Update
    public function profileSettingsUpdate(Request $request){
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->nft_address = $request->nft_address;
        $user->save();
        return back()->with(["info"=>"Profile Settings successfully","success"=>"NFT Receiving Wallet Updated successfully"]);
    }

    // Referral
    public function referral(){
        $data['general'] = GeneralSettings::first();
        $data['trxs'] = Transaction::where(['user_id'=>Auth::user()->id, 'service'=>'bonus'])->get();
        return view('referral', $data);
    }
}
