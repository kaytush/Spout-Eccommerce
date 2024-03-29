<?php

namespace App\Http\Controllers\Billers;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Deposit;
use App\Models\RefBonus;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GiftBills extends Controller
{

    // Process Airtime with Giftbills
    public function purchaseAirtime(Request $request)
    {
        $body = json_encode([
            'provider' => $request->provider,
             'amount' => $request->amount,
             'number' => $request->number,
             'reference'=> $request->reference,
        ]);
        Log::info("Processing Airtime Order ".$request->reference." ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('GIFTBILLS_URL').'airtime/topup',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"provider":"'.$request->provider.'",
            "number": "'.$request->number.'",
            "amount": "'.$request->amount.'",
            "reference": "'.$request->reference.'"
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('GIFTBILLS_KEY'),
            'MerchantId: '.env('GIFTBILLS_MID')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // Process Data with Giftbills
    public function purchaseData(Request $request)
    {
        $body = json_encode([
            'provider' => $request->provider,
             'plan_id' => $request->plan_id,
             'number' => $request->number,
             'reference'=> $request->reference,
        ]);
        Log::info("Processing Internet Data Order ".$request->reference." ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('GIFTBILLS_URL').'internet/data',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"provider":"'.$request->provider.'",
            "number": "'.$request->number.'",
            "plan_id": "'.$request->plan_id.'",
            "reference": "'.$request->reference.'"
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('GIFTBILLS_KEY'),
            'MerchantId: '.env('GIFTBILLS_MID')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // Process CableTv with Giftbills
    public function purchaseTv(Request $request)
    {
        $body = json_encode([
            'provider' => $request->provider,
             'plan_id' => $request->plan_id,
             'number' => $request->number,
             'reference'=> $request->reference,
        ]);
        Log::info("Processing Cable Tv Order ".$request->reference." ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('GIFTBILLS_URL').'tv/pay',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"provider":"'.$request->provider.'",
            "number": "'.$request->number.'",
            "plan_id": "'.$request->plan_id.'",
            "reference": "'.$request->reference.'"
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('GIFTBILLS_KEY'),
            'MerchantId: '.env('GIFTBILLS_MID')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // Validate Betting with Giftbills
    public function validateBetting(Request $request)
    {
        $body = json_encode([
            'provider' => $request->provider,
             'number' => $request->number,
        ]);
        Log::info("Validating Betting Account ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('GIFTBILLS_URL').'betting/validate',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"provider":"'.$request->provider.'",
            "customerId": "'.$request->number.'"
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('GIFTBILLS_KEY'),
            'MerchantId: '.env('GIFTBILLS_MID')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // Betting Topup with Giftbills
    public function bettingTopup(Request $request)
    {
        $body = json_encode([
            'provider' => $request->provider,
             'number' => $request->number,
             'amount' => $request->amount,
             'reference' => $request->reference,
        ]);
        Log::info("Validating Betting Account ".$body);

        $json = '{"amount":"' . $request->amount . '","customerId":"' . $request->number . '","provider":"' . $request->provider . '","reference":"' . $request->reference . '"}';

        $sec_key = hash_hmac('sha512', $json, env("GIFTBILLS_ENCRYPTION"));

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('GIFTBILLS_URL').'betting/topup',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$json,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('GIFTBILLS_KEY'),
            'Encryption: ' . $sec_key,
            'MerchantId: '.env('GIFTBILLS_MID')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

    // validate Electricity with Giftbills
    public function validateElectricity(Request $request)
    {
        $body = json_encode([
            'provider' => $request->provider,
             'number' => $request->number,
             'type' => $request->type,
        ]);
        Log::info("Validating Electricity Account ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('GIFTBILLS_URL') . "electricity/validate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"provider": "' . $request->provider . '","number": "' . $request->number . '","type": "' . $request->type . '"}',
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

    // Process Electricity with Giftbills
    public function purchaseElectricity(Request $request)
    {
        $body = json_encode([
            'provider' => $request->provider,
             'amount' => $request->amount,
             'number' => $request->number,
             'type' => $request->type,
             'reference'=> $request->reference,
        ]);
        Log::info("Processing Electricity Order ".$request->reference." ".$body);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => env('GIFTBILLS_URL').'electricity/recharge',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"provider":"'.$request->provider.'",
            "number": "'.$request->number.'",
            "amount": "'.$request->amount.'",
            "type": "'.$request->type.'",
            "reference": "'.$request->reference.'"
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('GIFTBILLS_KEY'),
            'MerchantId: '.env('GIFTBILLS_MID')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Log::info($response);

        $res = json_decode($response, true);

        return $res;
    }

}
