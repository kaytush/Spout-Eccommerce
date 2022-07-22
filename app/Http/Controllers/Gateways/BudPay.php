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
          CURLOPT_URL => env('GIFTBILLS_URL').'cable/tv',
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

}
