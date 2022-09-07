<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GiftBillsHookController extends Controller
{
    //======================================================================
    // GIFTBILLS WEBHOOKS STARTS HERE
    //======================================================================

    public function GiftBillsWebhooks(Request $request){
        $input = $request->all();

        Log::info("Incoming GiftBills Hook".json_encode($input));

        // RECEIVING RESPONSE FOR INTERNET ORDER
        if($input['event'] == "event.internet"){
            $transaction = Transaction::where('trx',$input['reference'])->first();
            $transaction->status = $input['status'];
            $transaction->errorMsg = $input['errorMsg'];
            $transaction->save();

            return response()->json(['success' => true, 200]);
        }

        // RECEIVING RESPONSE FOR BETTING ORDER
        if($input['event'] == "event.betting"){
            $transaction = Transaction::where('trx',$input['reference'])->first();
            $transaction->status = $input['status'];
            $transaction->errorMsg = $input['errorMsg'];
            $transaction->save();

            return response()->json(['success' => true, 200]);
        }

    }


    //======================================================================
    // GIFTBILLS WEBHOOKS ENDS HERE
    //======================================================================

}
