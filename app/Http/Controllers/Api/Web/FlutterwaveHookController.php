<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FlutterwaveHookController extends Controller
{
    //======================================================================
    // FLUTTERWAVE WEBHOOKS STARTS HERE
    //======================================================================

    // Flutterwave callback
    public function flutterwaveWebhooks(Request $request)
    {
        // If you specified a secret hash, check for the signature
        $secretHash = env('FLUTTERWAVE_SECRET_HASH');
        $signature = $request->header('verif-hash');
        if (!$signature || ($signature !== $secretHash)) {
            // This request isn't from Flutterwave; discard
            Log::info("Fake incoming flutterwave deposit payload - ".json_encode($request->all()));
            abort(401);
        }
        $payload = $request->all();
        // It's a good idea to log all received events.
        Log::info("Incoming Flutterwave Hook".json_encode($payload));
        // check if already credited
        $deposit=Deposit::where('trx', $payload['txRef'])->first();
        if($deposit->status == 1){
            Log::notice($payload['txRef']." Already credited");
            return response(200);
        }
        // Do something (that doesn't take too long) with the payload
        if($deposit->amount != $payload['amount']){
            Log::notice($payload['txRef']." Amount stated not paid. and can not be approved.");
            abort(401);
        }

        if($payload['status'] != "successful"){
            Log::notice($payload['txRef']." Payment not successful and user can not be credited.");
            abort(401);
        }

        $deposit->trans=$payload['flwRef'];
        $deposit->status=1;
        $deposit->save();

        $gnl = GeneralSettings::first();

        // check transaction log
        $trx_log=Transaction::where('trx', $deposit->trx)->first();
        if($trx_log){
            return response(200);
            Log::notice($payload['txRef']." Transaction already logged. can not proceed to crediting user.");
        }

        $u=User::find($deposit->user_id);

        //log transaction history
        Transaction::create([
            'user_id' => $deposit->user_id,
            'title' => 'Wallet Funding',
            'service_type' => "deposit",
            'icon' => 'flutterwave',
            'provider' => 'Flutterwave',
            'recipient' => $u->username,
            'description' => 'You funded your wallet balance with the sum of '.$gnl->currency_sym.$deposit->amount,
            'amount' => $deposit->amount,
            'discount' => 0,
            'fee' => 0,
            'total' => $deposit->amount,
            'init_bal' => $u->balance,
            'new_bal' => $u->balance + $deposit->amount,
            'wallet' => "balance",
            'reference' => $payload['flwRef'],
            'trx' => $deposit->trx,
            'channel' => "WEBSITE",
            'type' => 1,
            'status' => $payload['status'],
            'errorMsg' => "Deposit ".$payload['status'],

        ]);

        $u->balance+=$deposit->amount;
        $u->save();


        $to = $u->email;
        $name = $u->firstname;
        $subject = "Deposit Successful";
        $message = "You have successfully funded your wallet balance with the sum of " . $gnl->currency."". $deposit->amount . " via Flutterwave <br>Thank you for choosing " . $gnl->sitename;
        send_email($to, $name, $subject, $message);

        Log::info("Email successfully sent to ".$u->firstname." ".$u->email." for deposit approved and credited.");

        return response(200);
    }


    //======================================================================
    // FLUTTERWAVE WEBHOOKS ENDS HERE
    //======================================================================

}
