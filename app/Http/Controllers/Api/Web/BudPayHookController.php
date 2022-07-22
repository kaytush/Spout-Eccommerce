<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Deposit;
use App\Models\Nuban;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BudPayHookController extends Controller
{
    //======================================================================
    // PAYSTACK WEBHOOKS STARTS HERE
    //======================================================================

    public function budpayWebhooks(Request $request){
        // If you specified a secret hash, check for the signature
        $secretHash = hash_hmac('sha512', env('BUD_PK_KEY'), env('BUD_SK_KEY'));
        $signature = $request->header('merchantSignature');
        if (!$signature || ($signature !== $secretHash)) {
            // This request isn't from Budpay; discard
            Log::info("Fake incoming budpay deposit payload - ".json_encode($request->all()));
            abort(401);
        }
        $input = $request->all();

        //RECEIVING DEDICATED NUBAN TRANSFER
        if($input['notify'] == "transaction"){
            if($input['data']['status'] == "success"){
                // card deposit
                if($input['data']['type'] == "transaction"){}
                // bank transfer deposit
                if($input['data']['type'] == "dedicated_nuban"){}
            }

            //check if payment has channel set
            if(isset($input['data']['authorization']['channel'])){
                //confirm if payment is from dedicated number
                if($input['data']['authorization']['channel'] == "dedicated_nuban"){
                    $amount = $input['data']['amount'] / 100;
                    $sender_name = $input['data']['authorization']['sender_name'];
                    $sender_bank = $input['data']['authorization']['sender_bank'];
                    $sender_account = $input['data']['authorization']['sender_bank_account_number'];
                    $narration = $input['data']['authorization']['narration'];
                    $receiver_bank = $input['data']['authorization']['receiver_bank'];
                    $receiver_account = $input['data']['authorization']['receiver_bank_account_number'];

                    // find account number user match
                    $nuban = Nuban::where('account_number', $receiver_account)->where('bank_name', $receiver_bank)->first();
                    // find account user
                    $user = User::where('id', $nuban->user_id)->first();

                    if($amount < 6001){
                        $fee = 50;
                    }elseif($amount >6000){
                        $fee = 70;
                    }

                    $credit = $amount - $fee;
                    $trx = Carbon::now()->timestamp . rand();
                    $gnl = GeneralSettings::first();

                    //Deposit Log
                    $fund['user_id'] = $user->id;
                    $fund['amount'] = $amount;
                    $fund['fee'] = $fee;
                    $fund['total_amount'] = $credit;
                    $fund['trx'] = $trx;
                    $fund['gateway'] = 2;
                    $fund['status'] = 1;
                    Deposit::create($fund);

                    //log transaction history
                    Transaction::create([
                        'user_id' => $user->id,
                        'title' => 'Fund Transfer',
                        'description' => $narration.' | '.$sender_account,
                        'service' => 'deposit',
                        'amount' => $amount,
                        'type' => 1,
                        'trx' => $trx,
                    ]);

                    $user->balance+=$credit;
                    $user->save();


                    $to = $user->email;
                    $name = $user->firstname;
                    $subject = "Bank Transfer Received";
                    $message = "We wish to inform you that a Credit transaction occurred on your account with us. <br><br> Sender Account Name : ".$sender_name." <br> Sender Account Number : ".$sender_account." <br> Sender Bank Name : ".$sender_bank." <br> Amount : ".$gnl->currency." ".number_format($amount,$gnl->decimal)." <br> Naration : ".$narration." <br> New Balance : ".$gnl->currency." ".number_format($user->balance,$gnl->decimal)." <br> <br>Thank you for choosing " . $gnl->sitename;
                    send_email($to, $name, $subject, $message);

                    return response()->json(['success' => true, 200]);
                }
            }

        }

    }


    //======================================================================
    // PAYSTACK WEBHOOKS ENDS HERE
    //======================================================================

}
