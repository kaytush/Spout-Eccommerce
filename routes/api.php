<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Web\FlutterwaveHookController;
use App\Http\Controllers\Api\Web\BudPayHookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Budpay Webhook (All webhooks from budpay)
Route::post('/budpay/webhooks', [BudPayHookController::class, 'budpayWebhooks']);

//Flutterwave Webhook (All webhooks from flutterwave)
Route::post('/flutterwave/webhooks', [FlutterwaveHookController::class, 'flutterwaveWebhooks']);
