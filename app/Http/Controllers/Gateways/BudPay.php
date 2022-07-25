<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BudPay extends Controller
{

    // Get bank list
    public function bankList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('BUD_URL').'bank_list',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('BUD_SK_KEY')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // Account name verify
    public function accountNameVerify(Request $request)
    {
        $body = json_encode([
            'bank_code' => $request->bank_code,
             'account_number' => $request->account_number,
        ]);
        Log::info("Verifying Account name ... ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('BUD_URL').'account_name_verify',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"bank_code":"'.$request->bank_code.'",
            "account_number": "'.$request->account_number.'"
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('BUD_SK_KEY')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // Payment Link with Budpay
    public function generatePayLink(Request $request)
    {
        $body = json_encode([
            'email' => $request->email,
             'amount' => $request->amount,
             'currency' => $request->currency,
             'ref'=> $request->ref,
             'callback'=> $request->callback,
        ]);
        Log::info("Budpay Payment Link generating for Wallet Funding ".$request->ref." ".$body);

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
                "email": "' . $request->email . '",
                "amount": "' . $request->amount . '",
                "currency": "' . $request->currency . '",
                "ref": "' . $request->ref . '",
                "callback": "' . $request->callback . '"
                }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. env('BUD_SK_KEY'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        return $res;
    }

    // Confirm Payment
    public function confirmPayment($trx)
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

        return $res;
    }

    // Payment Link with Budpay
    public function bankTransfer(Request $request)
    {
        $body = json_encode([
            'currency' => $request->currency,
             'amount' => $request->amount,
             'bank_code' => $request->bank_code,
             'bank_name'=> $request->bank_name,
             'account_number'=> $request->account_number,
             'narration'=> $request->narration,
             'reference'=> $request->reference,
        ]);
        Log::info("Budpay Bank Transfer Processing ".$request->reference." ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('BUD_URL').'bank_transfer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "currency": "' . $request->currency . '",
                "amount": "' . $request->amount . '",
                "bank_code": "' . $request->bank_code . '",
                "bank_name": "' . $request->bank_name . '",
                "account_number": "' . $request->account_number . '",
                "narration": "' . $request->narration . '",
                "reference": "' . $request->reference . '"
                }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. env('BUD_SK_KEY'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        return $res;
    }

}
