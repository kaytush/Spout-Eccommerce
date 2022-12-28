<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Paylony extends Controller
{

    // Get bank list
    public function bankList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('PAYLONY_URL').'bank_list',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('PAYLONY_SECRET_KEY')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info("bank List Fetch Response ".$response);

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
          CURLOPT_URL => env('PAYLONY_URL').'account_name',
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
            'Authorization: Bearer '.env('PAYLONY_SECRET_KEY')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // Confirm Payment / Transaction Verify
    public function confirmPayment($trx)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('PAYLONY_URL')."transaction_verify/".$trx,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".env('PAYLONY_SECRET_KEY')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res=json_decode($response, true);

        return $res;
    }

    // Bank Transfer with Paylony
    public function bankTransfer(Request $request)
    {
        $body = json_encode([
             'amount' => $request->amount,
             'bank_code' => $request->bank_code,
             'sender_name'=> $request->sender_name,
             'account_number'=> $request->account_number,
             'narration'=> $request->narration,
             'reference'=> $request->reference,
        ]);
        Log::info("Paylony Bank Transfer Processing ".$request->reference." ".$body);

        $payload = '{"account_number":"'.$request->account_number.'","amount":"'.$request->amount.'","bank_code":"'.$request->bank_code.'","narration":"'.$request->narration.'","reference":"'.$request->reference.'","sender_name":"'.$request->sender_name.'"}';

        $signature = hash_hmac('sha512', $payload, env("PAYLONY_PUBLIC_KEY"));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('PAYLONY_URL').'bank_transfer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. env('PAYLONY_SECRET_KEY'),
                'Encryption: ' . $signature,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        return $res;
    }

}
