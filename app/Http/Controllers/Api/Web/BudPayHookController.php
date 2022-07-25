<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Deposit;
use App\Models\Nuban;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BudPayHookController extends Controller
{
    //======================================================================
    // BUDPAY WEBHOOKS STARTS HERE
    //======================================================================

    public function budpayWebhooks(Request $request){
        // If you specified a secret hash, check for the signature
        $secretHash = hash_hmac('sha512', env('BUD_PK_KEY'), env('BUD_SK_KEY'));
        $signature = $request->header('merchantSignature');
        if (!$signature || ($signature !== $secretHash)) {
            // This request isn't from Budpay; discard
            Log::alert("Fake incoming budpay deposit payload - ".json_encode($request->all()));
            abort(401);
        }
        $input = $request->all();

        // RECEIVING RESPONSE FOR BANK TANSFER (PAYOUT)
        if($input['notify'] == "transfer"){
            $transaction = Transaction::where('trx',$input['notify']['reference'])->first();
            $transaction->status = $input['data']['status'];
            $transaction->save();
            $transfer = Transfer::where('trx',$input['notify']['reference'])->first();
            $transfer->status = $input['data']['status'];
            $transfer->save();

            return response()->json(['success' => true, 200]);
        }

        //RECEIVING DEPOSIT NOTIFICATION
        if($input['notify'] == "transaction"){
            if($input['data']['status'] == "success"){
                // card deposit
                if($input['data']['type'] == "transaction"){
                    $dep = Deposit::where('trx',$input['notify']['reference'])->first();
                    if($dep->amount != $input['data']['amount']){
                        Log::info("Deposit amount does not tally - trx: ".$dep->trx);
                        abort(401);
                    }
                    if($dep->status == 1){
                        Log::info("Deposit already credited - trx: ".$dep->trx);
                        abort(401);
                    }else{
                        $dep->status = $input['data']['status'];
                        $dep->save();
                        // credit user
                        $user = User::where('id',$dep->user_id)->first();
                        $user->balance += $input['data']['amount'];
                        $user->save();

                        return response()->json(['success' => true, 200]);
                    }
                }
                // bank transfer deposit
                $gnl = GeneralSettings::first();
                $ref = Carbon::now()->format('YmdHi') . rand();
                $trx = $gnl->api_trans_prefix.$ref;
                $total_amount = $input['data']['amount'] - $gnl->vacc_fee;
                if($input['data']['type'] == "dedicated_nuban"){
                    $user = User::where('bp_customer_code',$input['data']['customer']['customer_code'])->first();
                    if(!$user){
                        Log::alert("Fake incoming budpay deposit payload - ".json_encode($request->all()));
                        abort(401);
                    }

                    $dep = Deposit::where('trans',$input['notify']['reference'])->first();
                    if(!$dep){
                        // Log Deposit
                        $fund['user_id'] = $user->id;
                        $fund['amount'] = $input['data']['amount'];
                        $fund['fee'] = $gnl->vacc_fee;
                        $fund['total_amount'] = $total_amount;
                        $fund['trx'] = $trx;
                        $fund['trans'] = $input['notify']['reference'];
                        $fund['gateway'] = "budpay";
                        $fund['status'] = "success";
                        Deposit::create($fund);

                        //log transaction history
                        Transaction::create([
                            'user_id' => $user->id,
                            'title' => 'Transfer Received',
                            'service_type' => "deposit",
                            'icon' => 'budpay',
                            'provider' => 'budpay',
                            'recipient' => $request->number,
                            'description' => 'Bank Transfer received with the sum of '.$gnl->currency_sym.$input['data']['amount'],
                            'amount' => $input['data']['amount'],
                            'discount' => 0,
                            'fee' => $gnl->vacc_fee,
                            'total' => $total_amount,
                            'init_bal' => $user->balance,
                            'new_bal' => $user->balance + $total_amount,
                            'wallet' => "balance",
                            'reference' => $input['notify']['reference'],
                            'trx' => $trx,
                            'channel' => "WEBSITE",
                            'type' => 1,
                            'status' => "success",
                            'errorMsg' => "Bank Transfer Received",

                        ]);

                        $user->balance+=$total_amount;
                        $user->save();

                        $to = $user->email;
                        $name = $user->firstname;
                        $subject = "Bank Transfer Received";
                        $message = "We wish to inform you that a Credit transaction occurred on your account with us. <br><br>Amount : ".$gnl->currency." ".number_format($input['data']['amount'],$gnl->decimal)." <br> New Balance : ".$gnl->currency." ".number_format($user->balance,$gnl->decimal)." <br> <br>Thank you for choosing " . $gnl->sitename;
                        send_email($to, $name, $subject, $message);

                        return response()->json(['success' => true, 200]);
                    }
                }
            }

        }

    }


    //======================================================================
    // BUDPAY WEBHOOKS ENDS HERE
    //======================================================================

}
