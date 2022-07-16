<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Billers\GiftBills;
use App\Models\GeneralSettings;
use App\Models\AirtimeProviders;
use App\Models\BettingProviders;
use App\Models\InternetProviders;
use App\Models\InternetData;
use App\Models\InternetDataType;
use App\Models\TvProviders;
use App\Models\TvBouquet;
use App\Models\ElectricityProviders;
use App\Models\ConvertAirtime;
use App\Models\ConvertAirtimeLog;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Activity;
use App\Models\BillsHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use File;

class BillsController extends Controller
{
    private $theme;

    public function __construct()
    {
        $this->theme = GeneralSettings::first()->theme; // theme name
    }

    // AIRTIME
    public function airtime(){
        $data['timenow'] = Carbon::now();
        $data['page_title'] = "Airtime Top-Up";
        $data['lists'] = AirtimeProviders::where(['status' => 1])->get();
        return view('theme.'.$this->theme.'.airtime.index', $data);
    }

    public function airtimeValidate(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'amount' => 'required|numeric',
        ],[
            'number.required' => 'Mobile Number required',
            'number.numeric' => 'Mobile Number cannot include an alphabet',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        $gnl = GeneralSettings::first();
        $network = AirtimeProviders::where(['status' => 1, 'provider' => $request->provider])->first();

        if($request->amount < $network->minAmount){
            $min = number_format($network->minAmount,$gnl->decimal);
            return back()->with(['error' => 'You cannot Topup below '.$gnl->currency_sym.$min]);
        }

        $discount = ($network->c_cent / 100) * $request->amount;

        Session::put('provider', $network->provider);
        Session::put('number', $request->number);
        Session::put('amount', $request->amount);
        Session::put('discount', $discount);

        return redirect()->route('airtime-preview');
    }

    public function airtimePreview(){
        $data['page_title'] = "Confirm Airtime Top-Up";
        $data['provider'] = Session::get('provider');
        $data['number'] = Session::get('number');
        $data['amount'] = Session::get('amount');
        $data['discount'] = Session::get('discount');
        $data['topup'] = AirtimeProviders::where(['provider' => $data['provider']])->first();

        return view('theme.'.$this->theme.'.airtime.preview', $data);
    }

    public function buyAirtime(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'amount' => 'required|numeric',
        ],[
            'number.required' => 'Mobile Number required',
            'number.numeric' => 'Mobile Number cannot include an alphabet',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        //check for max and min amount for by the provider
        $network = AirtimeProviders::where(['provider' => $request->provider])->first();

        $discount = ($network->c_cent / 100) * $request->amount;
        $total = $request->amount - $discount;
        $gnl = GeneralSettings::first();

        if($total < $network->minAmount){
            $min = number_format($network->minAmount,$gnl->decimal);
            return back()->with(['error' => 'Amount below the minimum Topup of '.$gnl->currency_sym.$min]);
        }

        if ($total > auth()->user()->balance) {
            return back()->with(['error' => 'Insufficient balance. Kindly topup your wallet']);
        }

        // charge user
        $current_bal = auth()->user()->balance;
        $u=User::find(auth()->user()->id);
        $u->balance -= $total;
        $u->save();

        $ref = Carbon::now()->format('YmdHi') . rand();
        $trx = $gnl->api_trans_prefix.$ref;

        // Log Airtime Order Attempt
        Log::info("Airtime Order Attempt for User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Trx: ".$trx." Source: WEBSITE".json_encode($request->all()));

        // start processing order
        $call = new GiftBills();
        $new = new Request([
            'provider' => $request->provider,
            'amount' => $request->amount,
            'number' => $request->number,
            'reference' => $trx,
        ]);
        $res = $call->purchaseAirtime($new);

        // Log Airtime Giftbills Response
        Log::info("Airtime Order Response for User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Trx: ".$trx." Source: WEBSITE".json_encode($res));

        if ($res['success'] == false){
            // Log Incoming AIRTEL CG DATA Attempt
            Log::alert("Failed Airtime Order Attempt by User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Trx: ".$trx." Source: WEBSITE");
            // balance auto reverse
            $u=User::find(auth()->user()->id);
            $u->balance = $current_bal;
            $u->save();
            return back()->with(['error' => 'Unable to Process this Transaction at the moment, Try again later']);
        }

        if ($res['success'] == true && $res['code'] == '00000'){

            //log transaction history
            Transaction::create([
                'user_id' => auth()->user()->id,
                'title' => $request->provider.' AIRTIME',
                'service_type' => "airtime",
                'icon' => strtolower($request->provider),
                'provider' => $request->provider,
                'recipient' => $request->number,
                'description' => $gnl->currency_sym.$request->amount.' '.$request->provider.' Airtime Topup on '.$request->number,
                'amount' => $request->amount,
                'discount' => $discount,
                'fee' => 0,
                'total' => $total,
                'init_bal' => $current_bal,
                'new_bal' => $current_bal - $total,
                'wallet' => "balance",
                'reference' => $res['data']['orderNo'],
                'trx' => $trx,
                'channel' => "WEBSITE",
                'type' => 0,
                'status' => $res['data']['status'],
                'errorMsg' => $res['data']['errorMsg'],

            ]);


            $to = $u->email;
            $name = $u->firstname;
            $subject = "Airtime Topup Successful";
            $message = "You have successfully Topup " . $request->number." on " . $request->provider." with the sum of " . $gnl->currency."". $request->amount . ". <br>Thank you for choosing " . $gnl->sitename;
            send_email($to, $name, $subject, $message);

            //REFERRAL EARNING PAYOUT ON NEW SERVER ORDER
            if(auth()->user()->referral != NULL){
                //calculate referral earning
                if($network->r_cent > 0){
                    $earn = ($network->r_cent * $request->amount)/100;
                }else{
                    $earn = 0;
                }

                if($earn > 0){
                    //find referral
                    $ref = User::where('username', auth()->user()->referral)->first();
                    $ref->earning+=$earn;
                    $ref->save();
                    //log transaction history
                    Transaction::create([
                        'user_id' => $ref->id,
                        'title' => 'Referral Earning',
                        'service_type' => "earning",
                        'icon' => "bonus",
                        'provider' => $request->provider,
                        'recipient' => $request->number,
                        'description' => 'Referral Earning on '.auth()->user()->firstname.' '.auth()->user()->lastname.' Airtime Purchase.',
                        'amount' => $earn,
                        'discount' => 0,
                        'fee' => 0,
                        'total' => $earn,
                        'init_bal' => $ref->earning,
                        'new_bal' => $ref->earning + $earn,
                        'wallet' => "earning",
                        'reference' => NULL,
                        'trx' => 'REF_'.$ref,
                        'channel' => "WEBSITE",
                        'type' => 1,
                        'status' => "successful",
                        'errorMsg' => NULL,

                    ]);
                    //send email to referral
                    $to = $ref->email;
                    $name = $ref->firstname;
                    $subject = "You have just earned some Cash";
                    $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                    send_email($to, $name, $subject, $message);
                }

            }

            return redirect()->route('airtime-success')->with(['success'=>'Airtime Topup Successful', 'amount'=>$request->amount, 'number'=>$request->number]);
        }else{

        // balance auto reverse
        $u=User::find(auth()->user()->id);
        $u->balance = $current_bal;
        $u->save();
            return back()->with(['error' => 'Unable to Process this Transaction at the moment, Try again later']);
        }
    }

    public function airtimeSuccess(){
        $data['page_title'] = "Airtime Top-Up";
        return view('theme.'.$this->theme.'.airtime.success', $data);
    }

    // INTERNET
    public function internet(){
        $data['page_title'] = "Internet Data";
        $data['lists'] = InternetProviders::where(['status' => 1])->get();
        $data['plans'] = InternetData::where(['status' => 1])->get();
        $data['airtel'] = InternetData::where(['status'=>1, 'ip_name'=>'AIRTEL'])->get();
        return view('theme.'.$this->theme.'.internet.index', $data);
    }

    public function internetValidate(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'code' => 'required',
        ],[
            'number.required' => 'Mobile Number required',
            'number.numeric' => 'Mobile Number cannot include an alphabet',
        ]);

        Session::put('provider', $request->provider);
        Session::put('number', $request->number);
        Session::put('code', $request->code);

        return redirect()->route('internet-preview');
    }

    public function internetPreview(){
        $data['page_title'] = "Internet Data Preview";
        $data['provider'] = Session::get('provider');
        $data['number'] = Session::get('number');
        $data['code'] = Session::get('code');
        $data['network'] = InternetProviders::where(['status' => 1, 'provider' => $data['provider']])->first();
        $data['plan'] = InternetData::where(['status' => 1, 'ip_name' => $data['provider'], 'id' => $data['code']])->first();
        $data['amount'] = $data['plan']->amount;
        if(auth()->user()->level > 0){
            $disc = ($data['plan']->api_cent / 100) * $data['plan']->amount;
            $data['discount'] = $disc;
        }else{
            $disc = ($data['plan']->c_cent / 100) * $data['plan']->amount;
            $data['discount'] = $disc;
        }

        return view('theme.'.$this->theme.'.internet.preview', $data);
    }

    public function buyInternet(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'code' => 'required',
        ],[
            'number.required' => 'Mobile Number required',
            'number.numeric' => 'Mobile Number cannot include an alphabet',
        ]);

        //check for data plan pricing by the provider
        $network = InternetProviders::where(['provider' => $request->provider])->first();
        $plan = InternetData::where(['status' => 1, 'ip_name' => $network->provider, 'id' => $request->code])->first();

        if(auth()->user()->level > 0){
            $discount = ($plan->api_cent / 100) * $plan->amount;
            $total = $plan->amount - $discount;
        }else{
            $discount = ($plan->c_cent / 100) * $plan->amount;
            $total = $plan->amount - $discount;
        }

        if ($total > auth()->user()->balance) {
            return back()->with(['error' => 'Insufficient balance. Kindly topup your wallet']);
        }

        // charge user
        $current_bal = auth()->user()->balance;
        $u=User::find(auth()->user()->id);
        $u->balance -= $total;
        $u->save();

        $gnl = GeneralSettings::first();
        $ref = Carbon::now()->format('YmdHi') . rand();
        $trx = $gnl->api_trans_prefix.$ref;

        // Log Incoming Internet Data Attempt
        Log::info("Internet Data Order Attempt by User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Source: WEBSITE".json_encode($request->all()));

        // start processing order
        $call = new GiftBills();
        $new = new Request([
            'provider' => $request->provider,
            'plan_id' => $plan->code,
            'number' => $request->number,
            'reference' => $trx,
        ]);
        $res = $call->purchaseData($new);
        //Log response
        Log::notice("GB Response on Internet Data Order for User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Trx: ".$trx." Source: WEBSITE".json_encode($res));

        if ($res['success'] == true){

            //log transaction history
            Transaction::create([
                'user_id' => auth()->user()->id,
                'title' => $request->provider.' DATA',
                'service_type' => "internet",
                'icon' => strtolower($request->provider),
                'provider' => $request->provider,
                'recipient' => $request->number,
                'description' => $plan->name.' '.$request->provider.' Internet Data on '.$request->number,
                'amount' => $plan->amount,
                'discount' => $discount,
                'fee' => 0,
                'total' => $total,
                'init_bal' => $current_bal,
                'new_bal' => $current_bal - $total,
                'wallet' => "balance",
                'reference' => $res['data']['orderNo'],
                'trx' => $trx,
                'channel' => "WEBSITE",
                'type' => 0,
                'status' => $res['data']['status'],
                'errorMsg' => $res['data']['errorMsg'],

            ]);


            $to = $u->email;
            $name = $u->firstname;
            $subject = "Internet Data Purchase Successful";
            $message = "You have successfully purchased " . $plan->name." on " . $request->number." with the sum of " . $gnl->currency."". $plan->amount . ". <br>Thank you for choosing " . $gnl->sitename;
            send_email($to, $name, $subject, $message);

            if(auth()->user()->level < 1){
                //REFERRAL EARNING PAYOUT ON NEW SERVER ORDER
                if(auth()->user()->referral != NULL){
                    //calculate referral earning
                    if($plan->r_cent > 0){
                        $earn = ($plan->r_cent * $plan->amount)/100;
                    }else{
                        $earn = 0;
                    }

                    if($earn > 0){
                        //find referral
                        $ref = User::where('username', auth()->user()->referral)->first();
                        $ref->earning+=$earn;
                        $ref->save();
                        //log transaction history
                        Transaction::create([
                            'user_id' => $ref->id,
                            'title' => 'Referral Earning',
                            'service_type' => "earning",
                            'icon' => "bonus",
                            'provider' => $request->provider,
                            'recipient' => $request->number,
                            'description' => 'Referral Earning on '.auth()->user()->firstname.' '.auth()->user()->lastname.' Internet Data Purchase.',
                            'amount' => $earn,
                            'discount' => 0,
                            'fee' => 0,
                            'total' => $earn,
                            'init_bal' => $ref->earning,
                            'new_bal' => $ref->earning + $earn,
                            'wallet' => "earning",
                            'reference' => NULL,
                            'trx' => 'REF_'.$ref,
                            'channel' => "WEBSITE",
                            'type' => 1,
                            'status' => "successful",
                            'errorMsg' => NULL,

                        ]);
                        //send email to referral
                        $to = $ref->email;
                        $name = $ref->firstname;
                        $subject = "You have just earned some Cash";
                        $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                        send_email($to, $name, $subject, $message);
                    }

                }
            }

            return redirect()->route('internet-success')->with(['success'=>'Internet Data Purchase successfully', 'name'=>$plan->name, 'number'=>$request->number]);
        }else{
            // balance auto reverse
            $u=User::find(auth()->user()->id);
            $u->balance = $current_bal;
            $u->save();
            return back()->with(['error' => 'Unable to Process this Transaction at the moment, Try again later']);
        }
    }

    public function internetSuccess(){
        $data['page_title'] = "Internet Data";
        return view('theme.'.$this->theme.'.internet.success', $data);
    }

    // CABLE TV
    public function tv(){
        $data['page_title'] = "Cable TV Subscription";
        $data['lists'] = TvProviders::where(['status' => 1])->get();
        $data['plans'] = TvBouquet::where(['status' => 1])->get();
        $data['dstv'] = TvBouquet::where(['status'=>1, 'tvp_name'=>'DSTV'])->get();
        return view('theme.'.$this->theme.'.tv.index', $data);
    }

    public function tvValidate(Request $request)
    {
        if($request->provider == "SHOWMAX"){
            $request->validate([
                'provider' => 'required|string',
                'number' => 'required|numeric',
            ],[
                'number.required' => 'Phone Number required',
                'number.numeric' => 'Phone Number cannot include an alphabet',
            ]);
        }else{
            $request->validate([
                'provider' => 'required|string',
                'number' => 'required|numeric',
            ],[
                'number.required' => 'Smartcard/UIC Number required',
                'number.numeric' => 'Smartcard/UIC Number cannot include an alphabet',
            ]);
        }

        if($request->provider == "STARTIMES" || $request->provider == "SHOWMAX"){
            $request->validate([
                'code' => 'required',
            ],[
                'code.required' => 'Select a TV Bouquet',
            ]);
        }else{
            $request->validate([
                'code' => 'required',
            ],[
                'code.required' => 'Select a TV Bouquet',
            ]);
        }

        if($request->provider != "SHOWMAX"){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('GIFTBILLS_URL') . "tv/validate",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"provider": "' . $request->provider . '","number": "' . $request->number . '"}',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.env('GIFTBILLS_KEY'),
                    'MerchantId: '.env('GIFTBILLS_MID')
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            curl_close($curl);


            $res = json_decode($response, true);

            if(isset($res['content']['error'])){
                return back()->with(['error' => 'Incorrect SmartCard number. Please try with a correct one']);
            }

            if ($res['success'] == true){
                Session::put('provider', $request->provider);
                Session::put('number', $request->number);
                Session::put('code', $request->code);
                if(isset($res['data']['Customer_Name'])){
                    Session::put('Customer_Name', $res['data']['Customer_Name']);
                }else{
                    Session::put('Customer_Name', "");
                }

                return redirect()->route('tv-preview');
            }
        }elseif($request->provider == "SHOWMAX"){
            Session::put('provider', $request->provider);
            Session::put('number', $request->number);
            Session::put('code', $request->code);
            Session::put('Customer_Name', NULL);

                return redirect()->route('tv-preview');
        }

        return back()->with(['error' => 'Unable to Verify Smartcard Number at the moment, Try again later']);
    }

    public function verifyTv($provider, $number)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('GIFTBILLS_URL') . "tv/validate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"provider": "' . $provider . '","number": "' . $number . '"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.env('GIFTBILLS_KEY'),
                'MerchantId: '.env('GIFTBILLS_MID')
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);


        $res = json_decode($response, true);

        return $res;
    }

    public function tvPreview(){
        $data['page_title'] = "Cable TV Subscription Preview";
        $data['provider'] = Session::get('provider');
        $data['number'] = Session::get('number');
        $data['code'] = Session::get('code');
        $data['Customer_Name'] = Session::get('Customer_Name');
        $data['network'] = TvProviders::where(['status' => 1, 'provider' => $data['provider']])->first();
        $data['bouquet'] = TvBouquet::where(['status' => 1, 'tvp_name' => $data['provider'], 'id' => $data['code']])->first();
        $data['amount'] = $data['bouquet']->amount;
        $disc = ($data['network']->c_cent / 100) * $data['bouquet']->amount;
        $data['discount'] = $disc;

        return view('theme.'.$this->theme.'.tv.preview', $data);
    }

    public function payTv(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'code' => 'required',
        ],[
            'number.required' => 'Smartcard/UIC Number required',
            'number.numeric' => 'Mobile Number cannot include an alphabet',
        ]);

        //check for tv plan pricing by the provider
        $network = TvProviders::where(['provider' => $request->provider])->first();
        $plan = TvBouquet::where(['status' => 1, 'tvp_name' => $request->provider, 'id' => $request->code])->first();
        $discount = ($network->c_cent / 100) * $plan->amount;
        $total = $plan->amount - $discount;

        if ($total > auth()->user()->balance) {
            return back()->with(['error' => 'Insufficient balance. Kindly topup your wallet']);
        }

        // charge user
        $current_bal = auth()->user()->balance;
        $u=User::find(auth()->user()->id);
        $u->balance -= $total;
        $u->save();

        $gnl = GeneralSettings::first();
        $ref = Carbon::now()->format('YmdHi') . rand();
        $trx = $gnl->api_trans_prefix.$ref;

        // Log Incoming Cable Tv Attempt
        Log::info("Cable Tv Order Attempt by User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Source: WEBSITE".json_encode($request->all()));

        // start processing order
        $call = new GiftBills();
        $new = new Request([
            'provider' => $request->provider,
            'plan_id' => $plan->code,
            'number' => $request->number,
            'reference' => $trx,
        ]);
        $res = $call->purchaseTv($new);
        //Log response
        Log::notice("GB Response on Cable Tv Order for User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Trx: ".$trx." Source: WEBSITE".json_encode($res));

        if ($res['code'] == '000'){

            //log transaction history
            Transaction::create([
                'user_id' => auth()->user()->id,
                'title' => $request->provider.' Tv Sub',
                'service_type' => "tv",
                'icon' => strtolower($request->provider),
                'provider' => $request->provider,
                'recipient' => $request->number,
                'description' => $plan->name.' '.$request->provider.' Tv Subscription on '.$request->number,
                'amount' => $plan->amount,
                'discount' => $discount,
                'fee' => 0,
                'total' => $total,
                'init_bal' => $current_bal,
                'new_bal' => $current_bal - $total,
                'wallet' => "balance",
                'reference' => $res['data']['orderNo'],
                'trx' => $trx,
                'channel' => "WEBSITE",
                'type' => 0,
                'status' => $res['data']['status'],
                'purchased_code' => $res['data']['purchased_code'],
                'errorMsg' => $res['data']['errorMsg'],

            ]);

            $to = $u->email;
            $name = $u->firstname;
            $subject = "Tv Subscription Payment Successful";
            $message = "You have successfully purchased " . $plan->name." on " . $request->number." with the sum of " . $gnl->currency."". $plan->amount . ". <br>Thank you for choosing " . $gnl->sitename;
            send_email($to, $name, $subject, $message);

            //REFERRAL EARNING PAYOUT ON NEW SERVER ORDER
            if(auth()->user()->referral != NULL){
                //calculate referral earning
                if($network->r_cent > 0){
                    $earn = ($network->r_cent * $plan->amount)/100;
                }else{
                    $earn = 0;
                }

                if($earn > 0){
                    //find referral
                    $ref = User::where('username', auth()->user()->referral)->first();

                    //log transaction history
                    Transaction::create([
                        'user_id' => $ref->id,
                        'title' => 'Referral Earning',
                        'service_type' => "earning",
                        'icon' => "bonus",
                        'provider' => $request->provider,
                        'recipient' => $request->number,
                        'description' => 'Referral Earning on '.auth()->user()->firstname.' '.auth()->user()->lastname.' Tv Subscription Purchase.',
                        'amount' => $earn,
                        'discount' => 0,
                        'fee' => 0,
                        'total' => $earn,
                        'init_bal' => $ref->earning,
                        'new_bal' => $ref->earning + $earn,
                        'wallet' => "earning",
                        'reference' => NULL,
                        'trx' => 'REF_'.$ref,
                        'channel' => "WEBSITE",
                        'type' => 1,
                        'status' => "successful",
                        'errorMsg' => NULL,

                    ]);
                    $ref->earning+=$earn;
                    $ref->save();
                    //send email to referral
                    $to = $ref->email;
                    $name = $ref->firstname;
                    $subject = "You have just earned some Cash";
                    $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                    send_email($to, $name, $subject, $message);
                }

            }

            return redirect()->route('tv-success')->with(['success'=>'Tv Subscription Purchase successfully', 'name'=>$plan->name, 'number'=>$request->number]);
        }else{

        // balance auto reverse
        $u=User::find(auth()->user()->id);
        $u->balance = $current_bal;
        $u->save();
            return back()->with(['error' => 'Unable to Process this Transaction at the moment, Try again later']);
        }
    }

    // ELECTRICITY
    public function electricity(){
        $data['page_title'] = "Electricity Recharge";
        $data['lists'] = ElectricityProviders::where(['status' => 1])->get();
        return view('theme.'.$this->theme.'.electricity.index', $data);
    }

    public function electricityValidate(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'type' => 'required|string',
            'number' => 'required|numeric',
            'amount' => 'required|numeric',
        ],[
            'type.required' => 'Meter Type is required',
            'number.required' => 'Meter Number is required',
            'amount.required' => 'Amount is required',
            'number.numeric' => 'Meter Number cannot include an alphabet',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        $elect = ElectricityProviders::where(['status' => 1, 'provider' => $request->provider])->first();
        $gnl = GeneralSettings::first();

        if($request->amount < $elect->minAmount){
            $min = number_format($elect->minAmount,$gnl->decimal);
            return back()->with(['error' => 'You cannot Recharge below '.$gnl->currency_sym.$min]);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('VTPASS_URL') . "merchant-verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"serviceID": "' . $elect->code . '","billersCode": "' . $request->number . '","type": "' . $request->type . '"}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . env('VTPASS_AUTH'),
                'Content-Type: application/json'
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        if(isset($res['content']['error'])){
            return back()->with(['error' => 'Incorrect or Invalid Meter number. Please try with a correct one']);
        }

        if ($res['code'] == '000'){
            Session::put('provider', $request->provider);
            Session::put('number', $request->number);
            Session::put('type', $request->type);
            Session::put('amount', $request->amount);
            Session::put('Customer_Name', $res['content']['Customer_Name']);

            return redirect()->route('user.electricity-preview');
        }

        return back()->with(['error' => 'Unable to Verify Meter Number at the moment, Try again later']);
    }

    public function electricityPreview(){
        $data['page_title'] = "Electricity Recharge Preview";
        $data['provider'] = Session::get('provider');
        $data['number'] = Session::get('number');
        $data['type'] = Session::get('type');
        $data['amount'] = Session::get('amount');
        $data['Customer_Name'] = Session::get('Customer_Name');
        $data['network'] = ElectricityProviders::where(['status' => 1, 'provider' => $data['provider']])->first();
        $disc = ($data['network']->c_cent / 100) * $data['amount'];
        $data['discount'] = $disc;

        return view('user.bills.electricity-preview', $data);
    }

    public function electricityRecharge(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'type' => 'required|string|max:10',
            'code' => 'required',
            'amount' => 'required|numeric',
        ],[
            'number.required' => 'Meter Number required',
            'number.numeric' => 'Meter Number cannot include an alphabet',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        $network = ElectricityProviders::where(['status' => 1, 'provider' => $request->provider])->first();
        $discount = ($network->c_cent / 100) * $request->amount;
        $total = $request->amount - $discount;

        if ($total > auth()->user()->balance) {
            return back()->with(['error' => 'Insufficient balance. Kindly topup your wallet']);
        }

        // charge user
        $current_bal = auth()->user()->balance;
        $u=User::find(auth()->user()->id);
        $u->balance -= $total;
        $u->save();

        $trx = Carbon::now()->format('YmdHi') . rand();
        $phone = "07036218209";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('VTPASS_URL') . "pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"request_id": "' . $trx . '", "serviceID": "' . $request->code . '","variation_code": "' . $request->type . '","phone": "' . $phone . '","billersCode": "' . $request->number . '","amount": "' . $request->amount . '"}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . env('VTPASS_AUTH'),
                'Content-Type: application/json'
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        Log::notice("Electricity Order Response ".json_encode($res));

        if ($res['code'] == '000'){
            $gnl = GeneralSettings::first();

            //log transaction history
            Transaction::create([
                'user_id' => auth()->user()->id,
                'title' => $request->provider.' Electricity',
                'description' => $gnl->currency_sym.$request->amount.' Electricity Recharge on '.$request->number,
                'service' => 'bills',
                'amount' => $request->amount,
                'type' => 0,
                'trx' => $trx,
            ]);

            //log bill history
            $bill['user_id'] = auth()->user()->id;
            $bill['service_type'] = "electricity";
            $bill['provider'] = $request->provider;
            $bill['recipient'] = $request->number;
            $bill['amount'] = $request->amount;
            $bill['discount'] = $discount;
            $bill['fee'] = 0;
            $bill['voucher'] = 0;
            $bill['paid'] = $total;
            $bill['init_bal'] = $current_bal;
            $bill['new_bal'] = $bill['init_bal'] - $bill['paid'];
            $bill['trx'] = $trx;
            $bill['ref'] = $res['content']['transactions']['transactionId'];
            $bill['api_req_id'] = NULL;
            $bill['channel'] = "WEBSITE";
            if($request->provider == "PHED"){
                if (strtolower($request->type) == "prepaid") {
                    $bill['purchased_code'] = $res['purchased_code'];
                    $bill['units'] = $res['units']." kwH";
                } else {
                    $bill['purchased_code'] = $request->number;
                }
            }else{
                if (strtolower($request->type) == "prepaid") {
                    $bill['purchased_code'] = $res['purchased_code'];
                    if(isset($res['mainTokenUnits'])){
                        $bill['units'] = $res['mainTokenUnits']." kwH";
                    }else{
                        $bill['units'] = $res['units'];
                    }
                } else {
                    $bill['purchased_code'] = $request->number;
                }
            }

            $bill['status'] = $res['content']['transactions']['status'];
            $bill['errorMsg'] = $res['response_description'];
            BillsHistory::create($bill);

            $u->balance = $bill['new_bal'];
            $u->save();

            if (strtolower($request->type) == "prepaid"){
                $token = "Purchased Code: <b>".$bill['purchased_code']."</b> - Units: ".$bill['units'];
            }else{
                $token = "Purchased Code: <b>".$bill['purchased_code']."</b>";
            }

            $to = $u->email;
            $name = $u->firstname;
            $subject = "Electricity Recharge Successful";
            $message = "You have successfully recharged ".$request->provider." Meter Number ".$request->number." with the sum of ".$gnl->currency."".$request->amount . ". <br>".$token."<br>Thank you for choosing " . $gnl->sitename;
            send_email($to, $name, $subject, $message);
            $phone = auth()->user()->phone;
            $sms = $request->provider." Meter Number ".$request->number." - ".$token;
            send_sms($phone, $sms);

            //REFERRAL EARNING PAYOUT ON NEW SERVER ORDER
            if(auth()->user()->referral != NULL){
                $elect = ElectricityProviders::where(['status' => 1, 'provider' => $request->provider])->first();
                //calculate referral earning
                if($elect->r_cent > 0){
                    $earn = ($elect->r_cent * $request->amount)/100;
                }else{
                    $earn = 0;
                }

                if($earn > 0){
                    //find referral
                    $ref = User::where('username', auth()->user()->referral)->first();
                    $ref->earning+=$earn;
                    $ref->save();
                    //log transaction history
                    Transaction::create([
                        'user_id' => $ref->id,
                        'title' => 'Referral Earning',
                        'description' => 'Referral Earning on '.auth()->user()->firstname.' '.auth()->user()->lastname.' Electricity Recharge Payment.',
                        'service' => 'earning',
                        'amount' => $earn,
                        'type' => 1,
                        'trx' => 'REF-'.$trx,
                    ]);
                    //send email to referral
                    $to = $ref->email;
                    $name = $ref->firstname;
                    $subject = "You have just earned some Cash";
                    $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                    send_email($to, $name, $subject, $message);
                }

            }

            return redirect()->route('user.electricity')->with('success', 'Electricity Recharged successfully');
        }else{

        // balance auto reverse
        $u=User::find(auth()->user()->id);
        $u->balance = $current_bal;
        $u->save();
            return back()->with(['error' => 'Unable to Process this Transaction at the moment, Try again later']);
        }
    }

    // BETTING
    public function bettingList(){
        $data['page_title'] = "Betting Top-Up";
        $data['lists'] = BettingProviders::where(['status' => 1])->get();
        return view('theme.'.$this->theme.'.betting.index', $data);
    }

    public function bettingValidate(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'customerId' => 'required',
            'amount' => 'required|numeric',
        ],[
            'customerId.required' => 'User ID required',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('OPAY_URL') . 'bills/validate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "serviceType": "betting",
                "provider": "'.$request->provider.'",
                "customerId": "'.$request->customerId.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'MerchantId: ' . env('OPAY_MERCHANTID'),
                'Authorization: Bearer ' . env('OPAY_PUBLICKEY'),
                'Content-Type: application/json',
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        if ($res['code'] == "00000" && $res['message'] == "SUCCESSFUL") {
            Session::put('amount', $request->amount);
            Session::put('provider', $res['data']['provider']);
            Session::put('customerId', $res['data']['customerId']);
            Session::put('firstName', $res['data']['firstName']);
            Session::put('lastName', $res['data']['lastName']);
            Session::put('userName', $res['data']['userName']);
            return redirect()->route('user.betting-preview');
        } else {
             return back()->withErrors('UserID/customerId could not be verified');
        }
        return back()->withErrors('UserID/customerId could not be verified or does not exist with this provider');
    }

    public function bettingPreview(){
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Betting Top-Up Preview";
        $data['amount'] = Session::get('amount');
        $data['provider'] = Session::get('provider');
        $data['customerId'] = Session::get('customerId');
        $data['firstName'] = Session::get('firstName');
        $data['lastName'] = Session::get('lastName');
        $data['userName'] = Session::get('userName');
        $data['bet'] = BettingProviders::where(['provider' => $data['provider']])->first();

        return view('user.bills.betting-preview', $data);
    }

    public function bettingTopUp(Request $request)
    {
        $betting_status = BillsList::where(['id' => 5])->first();
        if($betting_status->status ==0){
            return redirect()->route('user.dashboard')->with(["alert"=>"Betting Service is not available at the moment"]);
        }

        $request->validate([
            'provider' => 'required|string',
            'customerId' => 'required',
            'amount' => 'required|numeric',
        ],[
            'customerId.required' => 'User ID required',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        //check for max and min amount for by the provider
        $prov = BettingProviders::where(['provider' => $request->provider])->first();

        if ($prov->minAmount > $request->amount) {
            return back()->withErrors('Amount below minimum amount by the provider');
        }
        if ($prov->maxAmount != NULL && $prov->maxAmount < $request->amount) {
            return back()->withErrors('Amount more than maximum amount by the provider');
        }

        if ($request->amount > auth()->user()->balance) {
            return back()->withErrors('Insufficient balance. Kindly topup your wallet');
        }

        $trx = Carbon::now()->format('YmdHi') . rand();
        $amount = $request->amount * 100;

        $json = '{"bulkData":[{"amount":"'.$amount.'","country":"NG","currency":"NGN","customerId":"'.$request->customerId.'","provider":"'.$request->provider.'","reference":"'.$trx.'"}],"callBackUrl":"'.env('APP_URL').'/api/betting/callback","serviceType":"betting"}';

        $sec_key = hash_hmac('sha512', $json, env('OPAY_SECRETKEY'));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('OPAY_URL') . 'bills/bulk-bills',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$json,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $sec_key,
                'Content-Type: application/json',
                'MerchantId: ' . env('OPAY_MERCHANTID')
            ),
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        // Log Betting Topup response
        Log::info("Betting Topup Response for Username: ".auth()->user()->username." - UserID: ".auth()->user()->id." ".json_encode($res));

        if ($res['code'] == '10096'){
            return back()->with('error', 'Order failed [A.A.I.10096] Try again later');
        }

        if ($res['code'] == '04198'){
            return back()->with('error', 'Order already existed');
        }

        if ($res['data'][0]['status'] == 'FAIL'){
            return back()->with('error', 'Unable to Process this Transaction at the moment, Try again later');
        }

        $gnl = GeneralSettings::first();

        //log transaction history
        Transaction::create([
            'user_id' => auth()->user()->id,
            'title' => $request->provider.' Betting Topup',
            'description' => $gnl->currency_sym.$request->amount.' '.$request->provider.' Betting Topup on '.$request->customerId,
            'service' => 'bills',
            'amount' => $request->amount,
            'type' => 0,
            'trx' => $trx,
        ]);

        //activity log
        $activity['user_id'] =  auth()->user()->id;
        $activity['details'] =  'Betting Topup';
        $activity['remark'] =  'order';
        $activity['color'] =  'primary';
        Activity::create($activity);

        $u=User::find(auth()->user()->id);

        //log bill history
        $bill['user_id'] = auth()->user()->id;
        $bill['service_type'] = "betting";
        $bill['provider'] = $request->provider;
        $bill['recipient'] = $request->customerId;
        $bill['amount'] = $request->amount;
        $bill['discount'] = 0;
        $bill['fee'] = 0;
        $bill['voucher'] = 0;
        $bill['paid'] = $request->amount;
        $bill['init_bal'] = $u->balance;
        $bill['new_bal'] = $bill['init_bal'] - $bill['paid'];
        $bill['trx'] = $trx;
        $bill['ref'] = $res['data'][0]['orderNo'];
        $bill['api_req_id'] = NULL;
        $bill['channel'] = "WEBSITE";
        $bill['status'] = $res['data'][0]['status'];
        if(isset($res['data'][0]['errorMsg'])){
            $bill['errorMsg'] = $res['data'][0]['errorMsg'];
        }else{
            $bill['errorMsg'] = NULL;
        }
        BillsHistory::create($bill);

        $u->balance = $bill['new_bal'];
        $u->save();


        $to = $u->email;
        $name = $u->firstname;
        $subject = "Betting Topup Successful";
        $message = "You have successfully Topup " . $request->customerId." on " . $request->provider." with the sum of " . $gnl->currency."". $request->amount . ". <br>Thank you for choosing " . $gnl->sitename;
        send_email($to, $name, $subject, $message);

        //REFERRAL EARNING PAYOUT ON NEW SERVER ORDER
        if(auth()->user()->referral != NULL){
            //calculate referral earning
            if($prov->r_cent > 0){
                $earn = ($prov->r_cent * $request->amount)/100;
            }else{
                $earn = 0;
            }

            if($earn > 0){
                //find referral
                $ref = User::where('username', auth()->user()->referral)->first();
                $ref->earning+=$earn;
                $ref->save();
                //log transaction history
                Transaction::create([
                    'user_id' => $ref->id,
                    'title' => 'Referral Earning',
                    'description' => 'Referral Earning on '.auth()->user()->firstname.' '.auth()->user()->lastname.' Betting Top Up.',
                    'service' => 'earning',
                    'amount' => $earn,
                    'type' => 1,
                    'trx' => 'REF-'.$trx,
                ]);
                //send email to referral
                $to = $ref->email;
                $name = $ref->firstname;
                $subject = "You have just earned some Cash";
                $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                send_email($to, $name, $subject, $message);
            }

        }

        return redirect()->route('user.betting-list')->with('success', 'Betting Account Topup successfully');
    }

    //CHECK INTERNET STATUS
    public function checkInternetStatus($orderNo, $reference){
        $check = substr($orderNo, 0, 2);
        $ref = substr($orderNo, strpos($orderNo, "-") + 1);
        $vt_ref = $reference;
        if($check == "PK"){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('PRUDENTKONNECT_URL') . 'data/'.$ref,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Token ' . env('PRUDENTKONNECT_TOKEN')
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response, true);

            if ($res['id'] == $ref) {
                $bill = BillsHistory::where(['ref'=>$orderNo])->first();
                $bill->status = $res['Status'];
                $bill->save();
                return back()->with(["success"=>"Status Check & Updated Successfully"]);

            } else {
                return back()->withErrors('Unable to check status');
            }
        }elseif($check == "HW"){

        }else{

        }

        return back()->withErrors('Not processed');
    }

    //CHECK BETTING STATUS
    public function checkBettingStatus($orderNo, $reference){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('OPAY_URL') . 'bills/bulk-status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"bulkStatusRequest": [{"orderNo": "'.$orderNo.'","reference": "'.$reference.'"}],"serviceType": "betting"}',
            CURLOPT_HTTPHEADER => array(
                'MerchantId: ' . env('OPAY_MERCHANTID'),
                'Authorization: Bearer ' . env('OPAY_PUBLICKEY'),
                'Content-Type: application/json',
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        if ($res['code'] == "00000" && $res['message'] == "SUCCESSFUL") {
            if ($res['data'][0]['orderNo'] == $orderNo && $res['data'][0]['reference'] == $reference){
                $bill = BillsHistory::where(['trx'=>$reference, 'ref'=>$orderNo])->first();
                $bill->status = $res['data'][0]['status'];
                $bill->errorMsg = $res['data'][0]['errorMsg'];
                $bill->save();
                return back()->with(["success"=>"Status Check & Updated Successfully"]);
            }

        } else {
             return back()->withErrors('Unable to check status');
        }
        return back()->withErrors('Not processed');
    }

    // cron to check all pending betting status
    public function checkPendingBettingStatus(){
        $bets = BillsHistory::where(['service_type'=>"betting",'status'=>"PENDING"])->get();

        foreach($bets as $data){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('OPAY_URL') . 'bills/bulk-status',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{"bulkStatusRequest": [{"orderNo": "'.$data->ref.'","reference": "'.$data->trx.'"}],"serviceType": "betting"}',
                CURLOPT_HTTPHEADER => array(
                    'MerchantId: ' . env('OPAY_MERCHANTID'),
                    'Authorization: Bearer ' . env('OPAY_PUBLICKEY'),
                    'Content-Type: application/json',
                ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response, true);

            Log::notice("Cron Job Check Response: ".json_encode($res)." - for Ref: ".$data->trx);

            if ($res['code'] == "00000" && $res['message'] == "SUCCESSFUL") {
                if ($res['data'][0]['orderNo'] == $data->ref && $res['data'][0]['reference'] == $data->trx){
                    $bill = BillsHistory::where(['trx'=>$data->trx, 'ref'=>$data->ref])->first();
                    $bill->status = $res['data'][0]['status'];
                    $bill->errorMsg = $res['data'][0]['errorMsg'];
                    $bill->save();
                }

            }
        }

    }

    //PAY CLIENT REFUND FOR FAILED ORDER
    public function refundClientBill($id){
        $bill = BillsHistory::where(['id'=>$id])->first();

        if($bill->debit == "balance"){
            $descrpt = 'Refund on trx '.$bill->trx.' - '.$bill->provider.' - '.$bill->recipient.' '.$bill->service_type;
            $refund = $bill->paid;
            $rate = $bill->paid;
        }elseif($bill->debit == "cg"){
            $descrpt = 'Refund on trx '.$bill->trx.' - '.$bill->provider.' - '.$bill->recipient.' '.$bill->service_type;
            $refund = $bill->cg;
            $rate = $bill->paid;
        }

        $trx = Carbon::now()->format('YmdHi') . rand();

        //log transaction history
        Transaction::create([
            'user_id' => $bill->user_id,
            'title' => 'Wallet Refund',
            'description' => $descrpt,
            'service' => 'earning',
            'amount' => $rate,
            'type' => 1,
            'trx' => $trx,
        ]);

        $bill->refunded = 1;
        $bill->save();

        $user = User::find($bill->user_id);

        if($bill->debit == "balance"){
            $user->balance += $refund;
        }elseif($bill->debit == "cg"){
            $user->mtn_cg += $refund;
        }

        $user->save();

        return back()->with(["success"=>"Client Refunded Successfully"]);
    }

    //UPDATE BILL STATUS
    public function updateBillStatus($id,$status){
        $bill = BillsHistory::where(['id'=>$id])->first();
        $bill->status = $status;
        $bill->save();

        return back()->with(["success"=>"Bill Status Changed Successfully"]);
    }

    // CONVERT AIRITME
    public function convertAirtime(){
        $convert_airtime_status = BillsList::where(['id' => 6])->first();
        if($convert_airtime_status->status ==0){
            return redirect()->route('user.dashboard')->with(["alert"=>"Convert Airtime Service is not available at the moment"]);
        }
        $data['timenow'] = Carbon::now();
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Convert Airtime";
        $data['lists'] = ConvertAirtime::where(['status' => 1])->get();
        return view('user.bills.convertairtime-list', $data);
    }

    public function convertAirtimeSelect($provider){
        $convert_airtime_status = BillsList::where(['id' => 6])->first();
        if($convert_airtime_status->status ==0){
            return redirect()->route('user.dashboard')->with(["alert"=>"Convert Airtime Service is not available at the moment"]);
        }
        $data['timenow'] = Carbon::now();
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Convert Airtime";
        $data['network'] = ConvertAirtime::where(['status' => 1, 'provider' => $provider])->first();
        return view('user.bills.convert-airtime', $data);
    }

    public function convertAirtimeValidate(Request $request)
    {
        $convert_airtime_status = BillsList::where(['id' => 6])->first();
        if($convert_airtime_status->status ==0){
            return redirect()->route('user.dashboard')->with(["alert"=>"Convert Airtime Service is not available at the moment"]);
        }

        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'amount' => 'required|numeric',
            'type' => 'required|string',
        ],[
            'number.required' => 'Mobile Number required',
            'number.numeric' => 'Mobile Number cannot include an alphabet',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        $gnl = GeneralSettings::first();
        $network = ConvertAirtime::where(['status' => 1, 'provider' => $request->provider])->first();

        if($request->type == "wallet"){
            if($request->amount < $network->wallet_min){
                $min = number_format($network->wallet_min,$gnl->decimal);
                return back()->with(['error' => 'Minimum Airtime you can convert into your wallet is '.$gnl->currency_sym.$min]);
            }
        }
        if($request->type == "bank"){
            if($request->amount < $network->bank_min){
                $min = number_format($network->bank_min,$gnl->decimal);
                return back()->with(['error' => 'Minimum Airtime you can convert into your bank account is '.$gnl->currency_sym.$min]);
            }
        }

        Session::put('provider', $network->provider);
        Session::put('fee', $network->fee);
        Session::put('number', $request->number);
        Session::put('amount', $request->amount);
        Session::put('type', $request->type);

        return redirect()->route('user.convert-airtime-preview');
    }

    public function convertAirtimePreview(){
        $convert_airtime_status = BillsList::where(['id' => 6])->first();
        if($convert_airtime_status->status ==0){
            return redirect()->route('user.dashboard')->with(["alert"=>"Convert Airtime Service is not available at the moment"]);
        }
        $data['general'] = GeneralSettings::first();
        $data['page_title'] = "Convert Airtime Preview";
        $data['provider'] = Session::get('provider');
        $data['fee'] = Session::get('fee');
        $data['number'] = Session::get('number');
        $data['amount'] = Session::get('amount');
        $data['type'] = Session::get('type');
        $data['convert'] = ConvertAirtime::where(['provider' => $data['provider']])->first();

        return view('user.bills.convert-airtime-preview', $data);
    }

    public function convertAirtimeSubmit(Request $request)
    {
        $convert_airtime_status = BillsList::where(['id' => 6])->first();
        if($convert_airtime_status->status ==0){
            return redirect()->route('user.dashboard')->with(["alert"=>"Convert Airtime Service is not available at the moment"]);
        }

        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|numeric',
            'amount' => 'required|numeric',
            'type' => 'required|string',
        ],[
            'number.required' => 'Mobile Number required',
            'number.numeric' => 'Mobile Number cannot include an alphabet',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        $gnl = GeneralSettings::first();

        //check for max and min amount for by the provider
        $network = ConvertAirtime::where(['provider' => $request->provider])->first();

        if($request->type == "wallet"){
            if($request->amount < $network->wallet_min){
                $min = number_format($network->wallet_min,$gnl->decimal);
                return back()->with(['error' => 'Minimum Airtime you can convert into your wallet is '.$gnl->currency_sym.$min]);
            }
        }
        if($request->type == "bank"){
            if($request->amount < $network->bank_min){
                $min = number_format($network->bank_min,$gnl->decimal);
                return back()->with(['error' => 'Minimum Airtime you can convert into your bank account is '.$gnl->currency_sym.$min]);
            }
        }

        $trx = Carbon::now()->format('YmdHi') . rand();

        //activity log
        $activity['user_id'] =  auth()->user()->id;
        $activity['details'] =  'Airtime Conversion';
        $activity['remark'] =  'order';
        $activity['color'] =  'primary';
        Activity::create($activity);

        //fee rate
        $rate = $network->fee / 100;

        if($request->type == "wallet"){
            $fee_amount = $rate * $request->amount;
            $account = NULL;
        }elseif($request->type == "bank"){
            $fee_amount = ($rate * $request->amount) + 50;
            $account = auth()->user()->acc_details;
        }

        //convert airtime log
        $data['user_id'] =  auth()->user()->id;
        $data['p_id'] = $network->id;
        $data['provider'] = $request->provider;
        $data['number'] = $request->number;
        $data['type'] = $request->type;
        $data['amount'] = $request->amount;
        $data['fee_percent'] = $network->fee;
        $data['fee_amount'] = $fee_amount;
        $data['settled'] = $request->amount - $fee_amount;
        $data['account'] = $account;
        $data['trx'] = $trx;
        $data['status'] = 0;
        $dd = ConvertAirtimeLog::create($data);

        //log transaction history
        // Transaction::create([
        //     'user_id' => auth()->user()->id,
        //     'title' => 'Airtime Conversion',
        //     'description' => $gnl->currency_sym.$request->amount.' '.$request->provider.' Airtime Converted from '.$request->number,
        //     'service' => 'bills',
        //     'amount' => $request->amount,
        //     'type' => 1,
        //     'trx' => $trx,
        // ]);

        $data['page_title'] = "Convert Airtime";
        $data['id'] = $dd->id;
        $data['number'] = $dd->number;
        $data['amount'] = $dd->amount;
        $data['network'] = ConvertAirtime::where(['provider' => $dd->provider])->first();

        return view('user.bills.convert-details', $data);
    }

    public function convertAirtimeConfirm($id){
        $ca = ConvertAirtimeLog::findorFail($id);
        // $ca['status'] = 2;
        // $ca->save();
       return redirect()->route('user.convert-airtime')->with('success', 'Airtime Conversion Request submitted successfully. Your order is processing.');
    }

    //Bill History
    public function billsHistory(){
        $data['page_title'] = "Bill Payment History";
        $data['bills'] = BillsHistory::where(['user_id' => auth()->user()->id])->latest()->paginate(20);
        return view('user.bills.bill-history', $data);
    }

}
