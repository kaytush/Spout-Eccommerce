<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaylonyHookController extends Controller
{
    //======================================================================
    // PAYLONY WEBHOOKS STARTS HERE
    //======================================================================

    public function paylonyWebhooks(Request $request){
        $input = $request->all();
        Log::info("Incoming Webhook from Paylony - ".json_encode($input));

        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        }else if(isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }else{
            $ipaddress = 'UNKNOWN';
        }

        if($ipaddress != "89.117.60.210"){
            Log::info("Webhook not from Paylony IP address - ".json_encode($input));
            return response()->json(['success' => false, 'message' => 'Unathorized IP Access']);
        }

        $key = $request->bearerToken();
        if($key != env('PAYLONY_WEBHOOK_KEY')){
            Log::info("Unauthorized Webhook Key provided from Paylony - ".json_encode($input));
            return response()->json(['success' => false, 'message' => 'Unathorized Key Access']);
        }

        //RECEIVING DEDICATED ACCOUNT TRANSFER
        if($input['status'] == '00'){

            //check if payment has channel set
            if($input['event'] == 'collection' && $input['channel'] == 'bank_transfer'){
                //confirm if payment is for reserved account number
                if($input['type'] == "reserved_account" && $input['domain'] == "live"){
                    $amount = $input['amount'];
                    $sender_name = $input['sender_account_name'];
                    $sender_bank = $input['sender_bank_code'];
                    $sender_account = $input['sender_account_number'];
                    $narration = $input['sender_narration'];
                    $receiver_bank = $input['gateway'];
                    $receiver_account = $input['receiving_account'];

                    $dep = Deposit::where('order_no',$input['reference'])->first();
                    if(!$dep){
                        $gnl = GeneralSettings::first();

                        // find account number user match
                        $acc = User::where('account_number', $receiver_account)->where('bank_bank', 'VFD Bank')->first();
                        if(!$acc){
                            return response()->json(['success' => false, 'status' => '12', 'message' => 'Account not found in '.$gnl->sitename]);
                        }

                        $fee = $gnl->vacc_fee;
                        $credit = $amount - $fee;
                        $trx = Carbon::now()->timestamp . rand();

                        //Deposit Log
                        $fund['user_id'] = $acc->id;
                        $fund['amount'] = $amount;
                        $fund['fee'] = $fee;
                        $fund['total_amount'] = $credit;
                        $fund['trx'] = $trx;
                        $fund['trans'] = $input['trx'];
                        $fund['order_no'] = $input['reference'];
                        $fund['gateway'] = 'paylony';
                        $fund['status'] = 1;
                        Deposit::create($fund);

                        //log transaction history
                        Transaction::create([
                            'user_id' => $acc->id,
                            'title' => 'Transfer Received',
                            'service_type' => "deposit",
                            'icon' => 'paylony',
                            'provider' => 'paylony',
                            'recipient' => $request->number,
                            'description' => 'Bank Transfer received with the sum of '.$gnl->currency_sym.$amount,
                            'amount' => $amount,
                            'discount' => 0,
                            'fee' => $fee,
                            'total' => $credit,
                            'init_bal' => $acc->balance,
                            'new_bal' => $acc->balance + $credit,
                            'wallet' => "balance",
                            'reference' => $input['trx'],
                            'trx' => $trx,
                            'channel' => "WEBSITE",
                            'type' => 1,
                            'status' => "success",
                            'errorMsg' => "Bank Transfer Received",

                        ]);

                        $acc->balance+=$credit;
                        $acc->save();

                        $to = $acc->email;
                        $name = $acc->firstname;
                        $subject = "Bank Transfer Received";
                        $message = "We wish to inform you that a Credit transaction occurred on your account with us. <br><br>Amount : ".$gnl->currency." ".number_format($amount,$gnl->decimal)." <br> New Balance : ".$gnl->currency." ".number_format($acc->balance,$gnl->decimal)." <br> <br>Thank you for choosing " . $gnl->sitename;
                        send_email($to, $name, $subject, $message);

                        return response()->json(['success' => true, 'status' => '00'], 200);
                    }else{
                        Log::info("Bank Transfer Deposit already received and credited - trx: ".$dep->trx);
                        return response()->json(['success' => false, 'status' => 'already_recived'], 200);
                    }
                }
            }

        }

    }

    //======================================================================
    // PAYLONY WEBHOOKS ENDS HERE
    //======================================================================

}
