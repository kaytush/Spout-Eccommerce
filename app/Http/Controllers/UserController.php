<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Gateways\Paylony;
use App\Http\Controllers\Gateways\BudPay;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\State;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
            return view('theme.'.$this->theme.'.auth.authorization');
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
        $data['trxs'] = Transaction::where('user_id',Auth::user()->id)->latest()->paginate(20);
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
            $call = new BudPay();
            $new = new Request([
                'email' => auth()->user()->email,
                'amount' => $total_amount,
                'currency' =>  "NGN",
                'ref' => $trx,
                'callback' => env('APP_URL') . "/bdconfirmpayment/".$trx,
            ]);
            $res = $call->generatePayLink($new);

            Log::info("Budpay Payment link generated for deposit - ".json_encode($res));

            if($res['status'] == true){
                // log deposit
                $deposit=Deposit::where('trx', $trx)->first();
                $deposit->trx=$res['data']['reference'];
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
        $call = new BudPay();
        $res = $call->confirmPayment($trx);

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
        if(auth()->user()->bvn_status == 1){
            if(env('TRANSFER_PROVIDER') == 'paylony'){
                $call = new Paylony();
                $res = $call->bankList();

                if($res['success'] == true && $res['status'] == '00'){
                    $data['list'] = $res['data']['banks'];
                }else{
                    $data['list'] = [];
                }
            }else{
                $call = new BudPay();
                $res = $call->bankList();

                if(isset($res['success']) && $res['success'] == true){
                    $data['list'] = $res['data'];
                }else{
                    $data['list'] = [];
                }
            }
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
            $res = ['success' => true, 'status' => '00', 'message' => 'Account name retrieved', 'data' =>  $data];
        }else{
            // fetch account name from gateway provider
            if(env('TRANSFER_PROVIDER') == 'paylony'){
                $call = new Paylony();
                $new = new Request([
                    'bank_code' => $bank_code,
                    'account_number' => $account_number,
                ]);
                $res = $call->accountNameVerify($new);
            }else{
                $call = new BudPay();
                $new = new Request([
                    'bank_code' => $bank_code,
                    'account_number' => $account_number,
                ]);
                $res = $call->accountNameVerify($new);
            }
        }

        return $res;
    }

    // Transfer Validation
    public function transferValidate(Request $request)
    {
        $request->validate([
            'bankName' => 'required | string',
            'bank_code' => 'required | numeric',
            'amount' => 'required | numeric',
            'acc_name' => 'required | string',
        ]);

        if($request->bank_code == 0){
            $request->validate([
                'username' => 'required | string',
            ]);
        }else{
            $request->validate([
                'number' => 'required | numeric',
            ]);
        }

        $gnl = GeneralSettings::first();
        $total_amount = $request->amount + $gnl->transfer_fee;

        if($request->amount < 100){
            return back()->withErrors('Amount can not be less than 100');
        }

        if(auth()->user()->balance < 1){
            return back()->with(['error' => 'Insurficient Balance']);
        }

        $check = substr($request->amount, 0, 1);

        if($check == "-"){
            return back()->with(['error' => 'Invalid Amount']);
        }

        if($request->amount < 1){
            return back()->with(['error' => 'You can not transfer below 1 naira']);
        }

        if(auth()->user()->balance < $total_amount){
            return back()->with(['error' => 'Insurficient Balance']);
        }

        if($request->bank_code == 0){
            $fee = 0;
            $number = $request->username;
        }else{
            $fee = $gnl->transfer_fee;
            $number = $request->number;
        }

        Session::put('Amount', $request->amount);
        Session::put('number', $number);
        Session::put('bankName', $request->bankName);
        Session::put('bank_code', $request->bank_code);
        Session::put('acc_name', $request->acc_name);
        Session::put('fee', $fee);

        return redirect()->route('transfer-preview');

    }

    // Transfer Preview
    public function transferPreview()
    {
        $data['page_title'] = "Transfer Preview";
        $data['amount'] = Session::get('Amount');
        $data['number'] = Session::get('number');
        $data['bankName'] = Session::get('bankName');
        $data['bank_code'] = Session::get('bank_code');
        $data['acc_name'] = Session::get('acc_name');
        $data['fee'] = Session::get('fee');

        return view('theme.'.$this->theme.'.transfer.preview', $data);

    }

    // Confirm and transfer now
    public function transferNow(Request $request)
    {
        $request->validate([
            'bankName' => 'required | string',
            'bank_code' => 'required | numeric',
            'amount' => 'required | numeric',
            'number' => 'required',
        ]);

        $gnl = GeneralSettings::first();
        $ref = Carbon::now()->format('YmdHi') . rand();
        $trx = $gnl->api_trans_prefix.$ref;

        if($request->bank_code == 0){
            $fee = 0;
        }else{
            $fee = $gnl->transfer_fee;
        }

        $total_amount = $request->amount + $fee;

        if($request->amount < 100){
            return back()->withErrors('Amount can not be less than 100');
        }

        if(auth()->user()->balance < 1){
            return back()->with(['error' => 'Insurficient Balance']);
        }

        $check = substr($request->amount, 0, 1);

        if($check == "-"){
            return back()->with(['error' => 'Invalid Amount']);
        }

        if($request->amount < 1){
            return back()->with(['error' => 'You can not transfer below 1 naira']);
        }

        if(auth()->user()->balance < $total_amount){
            return back()->with(['error' => 'Insurficient Balance']);
        }

        // check if internal or external
        if($request->bank_code == 0){
            // internal
            $receiver = User::where('email', $request->number)->orWhere('username', $request->number)->orWhere('phone', $request->number)->first();

            if(!$receiver){
                return back()->with(['error' => 'Recipient account do not exist']);
            }

            if($receiver->id == auth()->user()->id){
                return back()->with(['error' => 'You cannot make wallet transfer to yourself']);
            }

            // debit sender
            $current_bal = auth()->user()->balance;
            $user = User::findOrFail(auth()->user()->id);
            $user->balance -= $total_amount;
            $user->save();

            //log transaction history - sender
            Transaction::create([
                'user_id' => auth()->user()->id,
                'title' => 'Wallet Transfer',
                'service_type' => "transfer",
                'icon' => "transfer",
                'provider' => $request->bankName,
                'recipient' => $request->number,
                'description' => $gnl->currency_sym.$request->amount.' Wallet Transfer sent to '.$receiver->username,
                'amount' => $request->amount,
                'discount' => 0,
                'fee' => $fee,
                'total' => $total_amount,
                'init_bal' => $current_bal,
                'new_bal' => $current_bal - $total_amount,
                'wallet' => "balance",
                'reference' => NULL,
                'trx' => $trx,
                'channel' => "WEBSITE",
                'type' => 0,
                'status' => "successful",
                'errorMsg' => NULL,

            ]);

            // credit receiver
            $r_current_bal = $receiver->balance;
            $receiver->balance += $request->amount;
            $receiver->save();
            //log transaction history - receiver
            Transaction::create([
                'user_id' => $receiver->id,
                'title' => 'Transfer Received',
                'service_type' => "transfer",
                'icon' => "transfer",
                'provider' => $request->bankName,
                'recipient' => $request->number,
                'description' => $gnl->currency_sym.$request->amount.' Wallet Transfer Received from '.auth()->user()->username,
                'amount' => $request->amount,
                'discount' => 0,
                'fee' => 0,
                'total' => $request->amount,
                'init_bal' => $r_current_bal,
                'new_bal' => $r_current_bal + $request->amount,
                'wallet' => "balance",
                'reference' => NULL,
                'trx' => $trx,
                'channel' => "WEBSITE",
                'type' => 1,
                'status' => "successful",
                'errorMsg' => NULL,

            ]);

            //log transfer history
            Transfer::create([
                'from' => auth()->user()->id,
                'to' => $receiver->id,
                'type' => "internal",
                'amount' => $request->amount,
                'fee' => 0,
                'total' => 0,
                'trx' => $trx,
                'status' => "successful",
            ]);
        }else{
            // external

            // debit sender
            $current_bal = auth()->user()->balance;
            $user = User::findOrFail(auth()->user()->id);
            $user->balance -= $total_amount;
            $user->save();

            // proccess transfer base on active gateway
            if(env('TRANSFER_PROVIDER') == 'paylony'){
                //paylony
                $call = new Paylony();
                // receiver details
                $new = new Request([
                    'bank_code' => $request->bank_code,
                    'account_number' => $request->number,
                ]);
                $receiver = $call->accountNameVerify($new);
                $rrv = $receiver['data']."|".$request->bank_code."|".$request->number;

                // initiate transfer
                $new = new Request([
                    'amount' => $request->amount,
                    'account_number' => $request->number,
                    'bank_code' =>  $request->bank_code,
                    'sender_name' => auth()->user()->firstname.' '.auth()->user()->lastname,
                    'narration' => $gnl->sitename." payout",
                    'reference' => $trx,
                ]);
                $res = $call->bankTransfer($new);

                Log::info("Paylony Transfer Attempt Response for trx: ".$trx." - ".json_encode($res));

                if($res['success'] != true && $res['status'] != '00'){
                    // auto reverse debited balance
                    $user->balance = $current_bal;
                    $user->save();
                    return back()->with(['error' => 'Service temporarily not available. Try again later or contact support']);
                }

                if($res['success'] == true && $res['status'] == '00'){
                    //log transaction history - sender
                    Transaction::create([
                        'user_id' => auth()->user()->id,
                        'title' => 'Bank Transfer',
                        'service_type' => "transfer",
                        'icon' => "transfer",
                        'provider' => $request->bankName,
                        'recipient' => $request->number,
                        'description' => $gnl->currency_sym.$request->amount.' Transfer to '.$rrv,
                        'amount' => $request->amount,
                        'discount' => 0,
                        'fee' => $fee,
                        'total' => $total_amount,
                        'init_bal' => $current_bal,
                        'new_bal' => $current_bal - $total_amount,
                        'wallet' => "balance",
                        'reference' => NULL,
                        'trx' => $trx,
                        'channel' => "WEBSITE",
                        'type' => 0,
                        'status' => 'successful',
                        'errorMsg' => NULL,

                    ]);

                    //log transfer history
                    Transfer::create([
                        'from' => auth()->user()->id,
                        'to' => $request->number,
                        'type' => "external",
                        'amount' => $request->amount,
                        'fee' => $fee,
                        'total' => $total_amount,
                        'trx' => $trx,
                        'status' => 'successful',
                    ]);
                }
            }else{
                // buday
                $call = new BudPay();
                $new = new Request([
                    'currency' => "NGN",
                    'amount' => $request->amount,
                    'bank_code' =>  $request->bank_code,
                    'bank_name' => $request->bankName,
                    'account_number' => $request->number,
                    'narration' => $gnl->sitename." payout",
                    'reference' => $trx,
                ]);
                $res = $call->bankTransfer($new);

                Log::info("Budpay Transfer Attempt Response for trx: ".$trx." - ".json_encode($res));

                if(isset($res['status'])){
                    if($res['status'] == false){
                        // auto reverse debited balance
                        $user->balance = $current_bal;
                        $user->save();
                        return back()->with(['error' => 'Service temporarily not available. Try again later or contact support']);
                    }
                }

                if($res['success'] == true){
                    $rrv = $res['data']['account_name']."|".$res['data']['account_number']."|".$res['data']['bank_code']."|".$res['data']['bank_name'];
                    //log transaction history - sender
                    Transaction::create([
                        'user_id' => auth()->user()->id,
                        'title' => 'Bank Transfer',
                        'service_type' => "transfer",
                        'icon' => "transfer",
                        'provider' => $request->bankName,
                        'recipient' => $request->number,
                        'description' => $gnl->currency_sym.$request->amount.' Transfer to '.$rrv,
                        'amount' => $request->amount,
                        'discount' => 0,
                        'fee' => $fee,
                        'total' => $total_amount,
                        'init_bal' => $current_bal,
                        'new_bal' => $current_bal - $total_amount,
                        'wallet' => "balance",
                        'reference' => NULL,
                        'trx' => $trx,
                        'channel' => "WEBSITE",
                        'type' => 0,
                        'status' => $res['data']['status'],
                        'errorMsg' => NULL,

                    ]);

                    //log transfer history
                    Transfer::create([
                        'from' => auth()->user()->id,
                        'to' => $request->number,
                        'type' => "external",
                        'amount' => $request->amount,
                        'fee' => $fee,
                        'total' => $total_amount,
                        'trx' => $trx,
                        'status' => $res['data']['status'],
                    ]);
                }
            }
        }

        return redirect()->route('transfer-success')->with(['success'=>'Fund transfer Successful', 'amount'=>$request->amount, 'number'=>$request->number]);

    }

    public function transferSuccess(){
        $data['page_title'] = "Fund Transfer";
        return view('theme.'.$this->theme.'.transfer.success', $data);
    }

    public function claimBonus(){
        $user = User::findorfail(auth()->user()->id);
        if(auth()->user()->earning < 1){
            return back()->with(['error'=>'No bonus to move']);
        }
        if(auth()->user()->earning == 0){
            return back()->with(['error'=>'No bonus to move']);
        }
        Log::info("Move Earning balance to main wallet balance for user ID: ".auth()->user()->id." - Email: ".auth()->user()->email." - Username: ".auth()->user()->username." - Current Balance: ".auth()->user()->balance." - Earning moved: ".auth()->user()->earning);

        $gnl = GeneralSettings::first();
        $ref = Carbon::now()->format('YmdHi') . rand();
        $trx = $gnl->api_trans_prefix.$ref;
        //log transaction history
        Transaction::create([
            'user_id' => auth()->user()->id,
            'title' => 'Earning Claimed',
            'service_type' => "balance",
            'icon' => "balance",
            'provider' => "Earning Wallet",
            'recipient' => "Balance Wallet",
            'description' => $gnl->currency_sym.auth()->user()->earning.' Earning balance Transfered to Main Balance',
            'amount' => auth()->user()->earning,
            'discount' => 0,
            'fee' => 0,
            'total' => auth()->user()->earning,
            'init_bal' => auth()->user()->balance,
            'new_bal' => auth()->user()->balance + auth()->user()->earning,
            'wallet' => "balance",
            'reference' => NULL,
            'trx' => $trx,
            'channel' => "WEBSITE",
            'type' => 1,
            'status' => "successful",
            'errorMsg' => NULL,

        ]);
        $user->balance += $user->earning;
        $user->earning = 0;
        $user->save();
        return back()->with(['success'=>'Bonus Moved to Balance Successfully']);
    }

    // Profile Settings
    public function profile(){
        $data['page_title'] = "Profile";
        $data['states'] = State::all();
        if(env('TRANSFER_PROVIDER') == 'paylony'){
            $call = new Paylony();
            $res = $call->bankList();

            if($res['success'] == true && $res['status'] == '00'){
                $data['list'] = $res['data']['banks'];
            }else{
                $data['list'] = [];
            }
        }else{
            $call = new BudPay();
            $res = $call->bankList();

            if(isset($res['success']) && $res['success'] == true){
                $data['list'] = $res['data'];
            }else{
                $data['list'] = [];
            }
        }

        return view('theme.'.$this->theme.'.account.profile', $data);
    }

    // Profile Update
    public function profileUpdate(Request $request){
        $user = User::find(Auth::user()->id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->save();

        // generate account if using paylony
        if(env('VIRTUAL_ACC') == 'paylony' && $user->account_number == NULL){
            $address = $user->address.', '.$user->city.', '.$user->state;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('PAYLONY_URL') . "create_account",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "firstname":"' . $user->firstname . '",
                    "lastname":"' . $user->lastname . '",
                    "address":"' . $address . '",
                    "gender":"' . $user->gender . '",
                    "email":"' . $user->email . '",
                    "phone":"' . $user->phone . '",
                    "dob":"' . $user->dob . '"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . env('PAYLONY_SECRET_KEY'),
                    'Content-Type: application/json'
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response, true);

            Log::notice("Customer Account created successfully".json_encode($res));

            if ($res['success'] == true && $res['status'] == '00'){
                // set bank name
                if($res['data']['provider'] == 'vfd'){
                    $bank_name = 'VFD Bank';
                }else{
                    $bank_name = $res['data']['provider'];
                }
                // $plny = User::findOrFail($user->id);
                $user->bank_name = $bank_name;
                $user->account_name = $res['data']['account_name'];
                $user->account_number = $res['data']['account_number'];
                $user->save();
            }
            // Paylony Account generated and saved
        }
        return back()->with(["success"=>"Profile Updated successfully"]);
    }

    public function verifyBvn(Request $request){
        $request->validate([
            'bank' => 'required|string',
            'acc_name' => 'required|string',
            'acc_no' => 'required|numeric',
            'bvn' => 'required|numeric',
        //
        ], [
            'bank.required' => 'Select your Bank',
            'acc_no.required' => 'Account Number Required',
            'acc_no.numeric' => 'Account Number can not include letters',
            'bvn.required' => 'BVN Number Required',
            'bvn.numeric' => 'BVN can not include letters',
        ]);

        $bank = json_decode($request->bank,TRUE);

        $gnl = GeneralSettings::first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('PAYSTACK_URL') . "customer/".auth()->user()->pk_customer_code."/identification",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"country": "NG","type": "bank_account","account_number": "' . $request->acc_no . '","bvn": "' . $request->bvn . '","bank_code": "' . $bank['id'] . '","first_name": "' . auth()->user()->firstname . '","last_name": "' . auth()->user()->lastname . '"}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Content-Type: application/json'
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        if ($res['status'] == false){
            return back()->with("error", $res['message']);
        }

        if ($res['status'] == true){
            $pkc = User::findOrFail(auth()->user()->id);
            $pkc->acc_details = '{"bank_code":"'.$bank['id'].'","bank_name":"'.$bank['name'].'","account_number":"'.$request->acc_no.'"}';
            $pkc->bvn = $request->bvn;
            $pkc->bvn_status = 2;
            $pkc->save();
            return back()->with("success", $res['message']);
        }

        return back()->with("error", "Unable to process your Account Match Verification. Kindly check if your account number, bvn or ".$gnl->sitename." account name match with the account and bvn provided");
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        $current_password = $request->current_password;
        $new_password = $request->password;
        if (Hash::check($current_password, auth()->user()->password)) {
            $request->user()->fill(['password' => Hash::make($new_password), 'pass_changed' => Carbon::now()])->save();

            return back()->with("success", "Password Changes Successfully.");
        } else {
            return back()->with("alert", "Current Password Not Match");
        }
    }

    public function accountSettings(){
        $data['page_title'] = "Account Settings";
        return view('theme.'.$this->theme.'.account.settings', $data);
    }

    // Referral
    public function referral(){
        $data['general'] = GeneralSettings::first();
        $data['trxs'] = Transaction::where(['user_id'=>Auth::user()->id, 'service'=>'bonus'])->get();
        return view('referral', $data);
    }
}
