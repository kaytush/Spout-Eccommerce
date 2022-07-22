<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Gateways\BudPay;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Session;
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

    //Fund Wallet
    public function fund(){
        $data['page_title'] = "Fund Wallet";
        return view('theme.'.$this->theme.'.fund.index', $data);
    }

    // fund wallet request
    public function fundWithCard(Request $request)
    {
        $request->validate([
            'bankName' => 'required | string',
            'amount' => 'required | numeric',
        ]);

        if($request->amount < 100){
            return back()->withErrors('Amount can not be less than 100');
        }

        Session::put('Amount', $request->amount);
        Session::put('bankName', $request->bankName);

        return redirect()->route('fund-preview');

    }

    public function fundPreview()
    {
        $data['page_title'] = "Fund Preview";
        $data['amount'] = Session::get('Amount');
        $data['bankName'] = Session::get('bankName');

        $data['trx'] = Carbon::now()->timestamp . rand();

        return view('theme.'.$this->theme.'.fund.preview', $data);

    }

    public function fundNow(Request $request)
    {
        $request->validate([
            'bankName' => 'required | string',
            'amount' => 'required | numeric',
            'trx' => 'required',
        ]);
        // $fee = (1.5 * $amount)/100;
        $fee = 0;
        $total_amount = $request->amount + $fee;
        $pick_trx = $request->trx;

        //check if trx already exist
        $c_trx = Deposit::where('trx', $pick_trx)->first();
        if(!$c_trx){
            $trx = $pick_trx;
        }else{
            $trx = Carbon::now()->timestamp . rand();
        }

        $fund['user_id'] = auth()->user()->id;
        $fund['amount'] = $request->amount;
        $fund['fee'] = $fee;
        $fund['total_amount'] = $total_amount;
        $fund['trx'] = $trx;
        $fund['gateway'] = $request->bankName;
        Deposit::create($fund);

        $data['firstname'] = auth()->user()->firstname;
        $data['lastname'] = auth()->user()->lastname;
        $data['name'] = auth()->user()->lastname . " ".auth()->user()->firstname;
        $data['email'] = auth()->user()->email;
        $data['phone'] = auth()->user()->phone;
        $data['amount'] = $request->amount;
        $data['fee'] = $fee;
        $data['total_amount'] = $total_amount;
        $data['trx'] = $trx;
        $data['key'] = env('FLUTTERWAVE_PUB_KEY');

        if($request->bankName == "flutterwave"){
            return view('payment.flutterwave-payment', $data);
        }
        elseif($request->bankName == "budpay"){
            // generate budpay payment link
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('BUD_URL').'transaction/initialize',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "email": "' . auth()->user()->email . '",
                    "amount": "' . $total_amount . '",
                    "currency": "NGN",
                    "ref": "' . $trx . '",
                    "callback": "' . env('APP_URL') . '/bdconfirmpayment/'.$trx.'"
                    }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '. env('BUD_SK_KEY'),
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response, true);

            Log::info("Budpay Payment link generated for deposit - ".json_encode($res));

            if($res['status'] == true){
                // log deposit
                $deposit=Deposit::where('trx', $trx)->first();
                $deposit->trans=$res['data']['access_code'];
                $deposit->save();
                // get link and redirect
                return redirect()->away($res['data']['authorization_url']);
            }else{
                // return error
                return back()->with('alert', 'payment option not available at the moment');
            }
        }

        return back()->with('alert', 'No Payment Option Selected');

    }

    // Flutterwave callback
    public function flconfirmpayment($trx, $trans)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('FLUTTERWAVE_URL')."transactions/".$trans."/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".env('FLUTTERWAVE_SEC_KEY')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res=json_decode($response, true);

        if($res['status']!="success"){
            return redirect()->route('dashboard')->with('alert', 'Invalid payment!');
        }

        $deposit=Deposit::where('trx', $trx)->first();
        $deposit->trans=$trans;
        $deposit->save();

        return redirect()->route('dashboard')->with('success', 'Fund Added successfully');
    }

    // Budpay callback
    public function bdconfirmpayment($trx)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('BUD_URL')."transaction/verify/:".$trx,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".env('BUD_SK_KEY')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res=json_decode($response, true);

        if($res['status']!="success"){
            return redirect()->route('dashboard')->with('alert', 'Invalid payment!');
        }else{
            return redirect()->route('dashboard')->with('alert', 'Fund Added Successfully');
        }

        return redirect()->route('dashboard')->with('success', 'Fund Added successfully');
    }

    //Wallet Transfer
    public function fundTransfer(){
        $data['page_title'] = "Fund Transfer";
        $call = new BudPay();
        $res = $call->bankList();

        if($res['success'] == true){
            $data['list'] = $res['data'];
        }else{
            $data['list'] = [];
        }
        return view('theme.'.$this->theme.'.transfer.index', $data);
    }

    // Account Name verify
    public function verifyAccName($bank_code, $account_number)
    {
        if($bank_code == 0){
            // fetch account name from system
            $receiver = User::where('email', $account_number)->orWhere('username', $account_number)->orWhere('phone', $account_number)->first();

            if(!$receiver){
                $data = NULL;
            }else{
                $data = $receiver->firstname." ".$receiver->lastname;
            }
            $res = ['success' => true, 'message' => 'Account name retrieved', 'data' => ['account_number' => '','account_name' => $data, 'bank_code' => 0,'bank_name' => '',]];
        }else{
            // fetch account name from gateway provider
            $call = new BudPay();
            $new = new Request([
                'bank_code' => $bank_code,
                'account_number' => $account_number,
            ]);
            $res = $call->accountNameVerify($new);
        }

        return $res;
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
