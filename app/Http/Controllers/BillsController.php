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

            if($gnl->email_notification == 1){
                $to = $u->email;
                $name = $u->firstname;
                $subject = "Airtime Topup Successful";
                $message = "You have successfully Topup " . $request->number." on " . $request->provider." with the sum of " . $gnl->currency."". $request->amount . ". <br>Thank you for choosing " . $gnl->sitename;
                send_email($to, $name, $subject, $message);
            }

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
                    if($gnl->email_notification == 1){
                        $to = $ref->email;
                        $name = $ref->firstname;
                        $subject = "You have just earned some Cash";
                        $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                        send_email($to, $name, $subject, $message);
                    }
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

            if($gnl->email_notification == 1){
                $to = $u->email;
                $name = $u->firstname;
                $subject = "Internet Data Purchase Successful";
                $message = "You have successfully purchased " . $plan->name." on " . $request->number." with the sum of " . $gnl->currency."". $plan->amount . ". <br>Thank you for choosing " . $gnl->sitename;
                send_email($to, $name, $subject, $message);
            }

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
                        if($gnl->email_notification == 1){
                            $to = $ref->email;
                            $name = $ref->firstname;
                            $subject = "You have just earned some Cash";
                            $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                            send_email($to, $name, $subject, $message);
                        }
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
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => env('GIFTBILLS_URL') . "tv/validate",
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => '{"provider": "' . $request->provider . '","number": "' . $request->number . '"}',
            //     CURLOPT_HTTPHEADER => array(
            //         'Content-Type: application/json',
            //         'Authorization: Bearer '.env('GIFTBILLS_KEY'),
            //         'MerchantId: '.env('GIFTBILLS_MID')
            //     ),
            // ));
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            // $response = curl_exec($curl);

            // curl_close($curl);


            // $res = json_decode($response, true);

            // if(isset($res['content']['error'])){
            //     return back()->with(['error' => 'Incorrect SmartCard number. Please try with a correct one']);
            // }

            // if ($res['success'] == true){
            //     Session::put('provider', $request->provider);
            //     Session::put('number', $request->number);
            //     Session::put('code', $request->code);
            //     if(isset($res['data']['Customer_Name'])){
            //         Session::put('Customer_Name', $res['data']['Customer_Name']);
            //     }else{
            //         Session::put('Customer_Name', "");
            //     }

            //     return redirect()->route('tv-preview');
            // }

            Session::put('provider', $request->provider);
            Session::put('number', $request->number);
            Session::put('code', $request->code);
            Session::put('Customer_Name', $request->acc_name);

            return redirect()->route('tv-preview');
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

    public function buyTv(Request $request)
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

        if($res['success'] == false){
            // balance auto reverse
            $u=User::find(auth()->user()->id);
            $u->balance = $current_bal;
            $u->save();
            return back()->with(['error' => 'Unable to process your request. Try again later.']);
        }
        if ($res['code'] == '00000'){

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

            if($gnl->email_notification == 1){
                $to = $u->email;
                $name = $u->firstname;
                $subject = "Tv Subscription Payment Successful";
                $message = "You have successfully purchased " . $plan->name." on " . $request->number." with the sum of " . $gnl->currency."". $plan->amount . ". <br>Thank you for choosing " . $gnl->sitename;
                send_email($to, $name, $subject, $message);
            }

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
                    if($gnl->email_notification == 1){
                        $to = $ref->email;
                        $name = $ref->firstname;
                        $subject = "You have just earned some Cash";
                        $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                        send_email($to, $name, $subject, $message);
                    }
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

    public function tvSuccess(){
        $data['page_title'] = "Cable TV Subscription";
        return view('theme.'.$this->theme.'.tv.success', $data);
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
            'number' => 'required',
            'amount' => 'required|numeric',
        ],[
            'type.required' => 'Meter Type is required',
            'number.required' => 'Meter Number is required',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        $elect = ElectricityProviders::where(['status' => 1, 'provider' => $request->provider])->first();
        $gnl = GeneralSettings::first();

        if($request->amount < $elect->minAmount){
            $min = number_format($elect->minAmount,$gnl->decimal);
            return back()->with(['error' => 'You cannot Recharge below '.$gnl->currency_sym.$min]);
        }

        // start electricity validation
        $call = new GiftBills();
        $new = new Request([
            'provider' => $request->provider,
            'number' => $request->number,
            'type' => $request->type,
        ]);
        $res = $call->validateElectricity($new);
        //Log response
        Log::notice("GB Response on Cable Tv Order for User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Source: WEBSITE".json_encode($res));

        if ($res['success'] == true){
            Session::put('provider', $request->provider);
            Session::put('number', $request->number);
            Session::put('type', $request->type);
            Session::put('amount', $request->amount);
            Session::put('Customer_Name', $res['data']['Customer_Name']);

            return redirect()->route('electricity-preview');
        } else {
             return back()->withErrors('Incorrect or Invalid Meter number. Please try with a correct one');
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

        return view('theme.'.$this->theme.'.electricity.preview', $data);
    }

    public function electricityRecharge(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required',
            'type' => 'required|string|max:10',
            'amount' => 'required|numeric',
        ],[
            'number.required' => 'Meter Number required',
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

        $gnl = GeneralSettings::first();
        $ref = Carbon::now()->format('YmdHi') . rand();
        $trx = $gnl->api_trans_prefix.$ref;
        $phone = "07036218209";

        // Log Incoming Electricity Attempt
        Log::info("Electricity Order Attempt by User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Source: WEBSITE".json_encode($request->all()));

        // start processing order
        $call = new GiftBills();
        $new = new Request([
            'provider' => $request->provider,
            'amount' => $request->amount,
            'number' => $request->number,
            'type' => $request->type,
            'reference' => $trx,
        ]);
        $res = $call->purchaseElectricity($new);
        //Log response
        Log::notice("GB Response on Electricity Order for User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Trx: ".$trx." Source: WEBSITE".json_encode($res));

        if ($res['status'] == true){

            //log transaction history
            Transaction::create([
                'user_id' => auth()->user()->id,
                'title' => $request->provider.' Electricity',
                'service_type' => "electricity",
                'icon' => strtolower($request->provider),
                'provider' => $request->provider,
                'recipient' => $request->number,
                'description' => $gnl->currency_sym.$request->amount.' '.$request->provider.' Electricity Recharge on '.$request->number,
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
                'purchased_code' => $res['data']['purchased_code'],
                'units' => $res['data']['units'],
                'errorMsg' => $res['data']['errorMsg'],

            ]);

            $token = "Purchased Code: <b>".$res['data']['purchased_code']."</b> - Units: ".$res['data']['units'];

            if($gnl->email_notification == 1){
                $to = $u->email;
                $name = $u->firstname;
                $subject = "Electricity Recharge Successful";
                $message = "You have successfully recharged ".$request->provider." Meter Number ".$request->number." with the sum of ".$gnl->currency."".$request->amount . ". <br>".$token."<br>Thank you for choosing " . $gnl->sitename;
                send_email($to, $name, $subject, $message);
            }
            if($gnl->sms_notification == 1){
                $phone = auth()->user()->phone;
                $sms = $request->provider." Meter Number ".$request->number." - ".$token;
                send_sms($phone, $sms);
            }

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
                        'service_type' => "earning",
                        'icon' => "bonus",
                        'provider' => $request->provider,
                        'recipient' => $request->number,
                        'description' => 'Referral Earning on '.auth()->user()->firstname.' '.auth()->user()->lastname.' Electricity Recharge.',
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
                    if($gnl->email_notification == 1){
                        $to = $ref->email;
                        $name = $ref->firstname;
                        $subject = "You have just earned some Cash";
                        $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                        send_email($to, $name, $subject, $message);
                    }
                }
            }
            return redirect()->route('electricity-success')->with(['success'=>'Electricity Recharged successfully', 'amount'=>$request->amount, 'number'=>$request->number]);
        }else{
            // balance auto reverse
            $u=User::find(auth()->user()->id);
            $u->balance = $current_bal;
            $u->save();
            return back()->with(['error' => 'Unable to Process this Transaction at the moment, Try again later']);
        }
    }

    public function electricitySuccess(){
        $data['page_title'] = "Electricity Recharge";
        return view('theme.'.$this->theme.'.electricity.success', $data);
    }

    // BETTING
    public function betting(){
        $data['page_title'] = "Betting Top-Up";
        $data['lists'] = BettingProviders::where(['status' => 1])->get();
        return view('theme.'.$this->theme.'.betting.index', $data);
    }

    public function bettingValidate(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required|max:15',
            'amount' => 'required|numeric',
        ],[
            'number.required' => 'User ID required',
            'amount.numeric' => 'Amount cannot include an alphabet',
        ]);

        // start account validation
        $call = new GiftBills();
        $new = new Request([
            'provider' => $request->provider,
            'number' => $request->number,
        ]);
        $res = $call->validateBetting($new);

        if ($res['code'] == "00000") {
            Session::put('amount', $request->amount);
            Session::put('provider', $res['data']['provider']);
            Session::put('number', $res['data']['customerId']);
            Session::put('firstName', $res['data']['firstName']);
            Session::put('lastName', $res['data']['lastName']);
            Session::put('userName', $res['data']['userName']);
            return redirect()->route('betting-preview');
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
        $data['number'] = Session::get('number');
        $data['firstName'] = Session::get('firstName');
        $data['lastName'] = Session::get('lastName');
        $data['userName'] = Session::get('userName');
        $data['bet'] = BettingProviders::where(['provider' => $data['provider']])->first();
        if(auth()->user()->level > 0){
            $data['discount'] = ($data['amount'] * $data['bet']->api_cent)/100;
        }else{
            $data['discount'] = ($data['amount'] * $data['bet']->c_cent)/100;
        }

        return view('theme.'.$this->theme.'.betting.preview', $data);
    }

    public function buyBetting(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'number' => 'required',
            'amount' => 'required|numeric',
        ],[
            'number.required' => 'User ID required',
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

        if(auth()->user()->level > 0){
            $discount = ($prov->api_cent / 100) * $request->amount;
            $total = $request->amount - $discount;
        }else{
            $discount = ($prov->c_cent / 100) * $request->amount;
            $total = $request->amount - $discount;
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

        // Log Incoming Betting Topup Attempt
        Log::info("Betting Topup Order Attempt by User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Source: WEBSITE".json_encode($request->all()));

        // start processing order
        $call = new GiftBills();
        $new = new Request([
            'provider' => $request->provider,
            'amount' => $request->amount,
            'number' => $request->number,
            'reference' => $trx,
        ]);
        $res = $call->bettingTopup($new);
        //Log response
        Log::notice("GB Response on Betting Topup Order for User: [id: ".auth()->user()->id.", username: ".auth()->user()->username."] Trx: ".$trx." Source: WEBSITE".json_encode($res));

        if ($res['success'] == false){
            // balance auto reverse
            $u=User::find(auth()->user()->id);
            $u->balance = $current_bal;
            $u->save();
            return back()->with('error', 'Order failed. Try again later');
        }

        //log transaction history
        Transaction::create([
            'user_id' => auth()->user()->id,
            'title' => $request->provider.' Betting Topup',
            'service_type' => "betting",
            'icon' => strtolower($request->provider),
            'provider' => $request->provider,
            'recipient' => $request->number,
            'description' => $gnl->currency_sym.$request->amount.' '.$request->provider.' Betting Topup on '.$request->number,
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
            'status' => "successful",
            'errorMsg' => $res['data']['errorMsg'],
        ]);

        if($gnl->email_notification == 1){
            $to = $u->email;
            $name = $u->firstname;
            $subject = "Betting Topup Successful";
            $message = "You have successfully Topup " . $request->customerId." on " . $request->provider." with the sum of " . $gnl->currency."". $request->amount . ". <br>Thank you for choosing " . $gnl->sitename;
            send_email($to, $name, $subject, $message);
        }

        if(auth()->user()->level < 1){
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
                        'service_type' => "earning",
                        'icon' => "bonus",
                        'provider' => $request->provider,
                        'recipient' => $request->number,
                        'description' => 'Referral Earning on '.auth()->user()->firstname.' '.auth()->user()->lastname.' Betting Top Up.',
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
                    if($gnl->email_notification == 1){
                        $to = $ref->email;
                        $name = $ref->firstname;
                        $subject = "You have just earned some Cash";
                        $message = "You have earned " . $gnl->currency."". $earn . " in our Referral Earning Program. Thank you for choosing " . $gnl->sitename;
                        send_email($to, $name, $subject, $message);
                    }
                }

            }
        }

        return redirect()->route('betting-success')->with(['success'=>'Betting Account Topup successfully', 'amount'=>$request->amount, 'number'=>$request->number]);
    }

    public function bettingSuccess(){
        $data['page_title'] = "Betting Top-Up";
        return view('theme.'.$this->theme.'.betting.success', $data);
    }

    //PAY CLIENT REFUND FOR FAILED ORDER
    public function refundClientBill($id){
        $bill = Transaction::where(['id'=>$id])->first();

        if($bill->refunded == 0){
            $descrpt = 'Refund on trx '.$bill->trx.' - '.$bill->provider.' - '.$bill->recipient.' '.$bill->service_type;
            $refund = $bill->paid;
            $rate = $bill->paid;

            $gnl = GeneralSettings::first();
            $trx = Carbon::now()->format('YmdHi') . rand();
            $u = User::find($bill->user_id);;

            //log transaction history
            Transaction::create([
                'user_id' => $bill->user_id,
                'title' => 'Wallet Refund',
                'service_type' => "balance",
                'icon' => "balance",
                'provider' => $bill->provider,
                'recipient' => $bill->number,
                'description' => $gnl->currency_sym.$bill->amount.' '.$bill->provider.' Betting Topup Refund on '.$bill->number,
                'amount' => $bill->amount,
                'discount' => 0,
                'fee' => 0,
                'total' => $bill->paid,
                'init_bal' => $u->balance,
                'new_bal' => $u->balance + $bill->paid,
                'wallet' => "balance",
                'reference' => NULL,
                'trx' => $trx,
                'channel' => "WEBSITE",
                'type' => 1,
                'status' => "successful",
                'errorMsg' => NULL,

            ]);

            $bill->refunded = 1;
            $bill->save();

            $u->balance += $refund;
            $u->save();

            return back()->with(["success"=>"Client Refunded Successfully"]);
        }else{
            return back()->with(["error"=>"Client Already Refunded"]);
        }
    }

    //UPDATE BILL STATUS
    public function updateBillStatus($id,$status){
        $bill = Transaction::where(['id'=>$id])->first();
        $bill->status = $status;
        $bill->save();

        return back()->with(["success"=>"Bill Status Changed Successfully"]);
    }

}
