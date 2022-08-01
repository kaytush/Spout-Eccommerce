<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('main');
    Route::get('/about', 'about')->name('about');
    Route::get('/help', 'help')->name('help');
    Route::get('/contact', 'contact')->name('contact');
});



// All Clients Routes Starts Here
Route::middleware(['middleware' => 'auth'])->group(function () {
    // checking status
    Route::controller(UserController::class)->group(function () {
        Route::get('maintenance', 'maintain')->name('maintain');
        Route::get('inactive', 'inactive')->name('inactive');
        Route::get('authorization', 'authCheck')->name('authorization');
        Route::post('verify-email', 'sendEmailVcode')->name('send-emailVcode');
        Route::post('postEmailVerify', 'postEmailVerify')->name('email-verify');
    });

    // after status checked
    Route::group(['middleware' => 'CheckStatus'], function () {
        // User Controller
        Route::controller(UserController::class)->group(function () {
            // User Dashboard
            Route::get('dashboard', 'dashboard')->name('dashboard');
            // User Profile & Settings
            Route::get('profile', 'profile')->name('profile');
            Route::get('account-settings', 'accountSettings')->name('account-settings');
            Route::post('update-profile', 'profileUpdate')->name('update-profile');
            Route::post('verify-bvn', 'verifyBVN')->name('verify-bvn');
            Route::post('change-password', 'submitPassword')->name('change-password');
            // Transaction History
            Route::get('transactions', 'transactions')->name('transactions');
            // Fund Wallet
            Route::get('fund', 'fund')->name('fund');
            Route::post('card-funding', 'fundWithCard')->name('card-funding');
            Route::get('fund-preview', 'fundPreview')->name('fund-preview');
            Route::post('fund-now', 'fundNow')->name('fund-now');
            Route::get('/bdconfirmpayment/{trx}', 'bdconfirmpayment')->name('bdconfirmpayment');
            Route::get('/flconfirmpayment/{trx}/{trans}', 'flconfirmpayment')->name('flconfirmpayment');
            // Fund Wallet
            Route::get('fund-transfer', 'fundTransfer')->name('fund-transfer');
            Route::get('/account_name/validate/{provider}/{number}', 'verifyAccName')->name('acc-name-verify');
            Route::post('validate-transfer', 'transferValidate')->name('validate-transfer');
            Route::get('transfer-preview', 'transferPreview')->name('transfer-preview');
            Route::post('transfer-now', 'transferNow')->name('transfer-now');
            Route::get('transfer-success', 'transferSuccess')->name('transfer-success');
            Route::get('claim-bonus', 'claimBonus')->name('claim-bonus');
        });
        // Bills Controller
        Route::controller(BillsController::class)->group(function () {
            // Airtime
            Route::get('airtime', 'airtime')->name('airtime');
            Route::post('validate-airtime', 'airtimeValidate')->name('validate-airtime');
            Route::get('airtime-preview', 'airtimePreview')->name('airtime-preview');
            Route::post('buy-airtime', 'buyAirtime')->name('buy-airtime');
            Route::get('airtime-success', 'airtimeSuccess')->name('airtime-success');
            // Internet Data
            Route::get('internet', 'internet')->name('internet');
            Route::post('validate-internet', 'internetValidate')->name('validate-internet');
            Route::get('internet-preview', 'internetPreview')->name('internet-preview');
            Route::post('buy-internet', 'buyInternet')->name('buy-internet');
            Route::get('internet-success', 'internetSuccess')->name('internet-success');
            // CableTv Data
            Route::get('tv', 'tv')->name('tv');
            Route::post('validate-tv', 'tvValidate')->name('validate-tv');
            Route::get('/tv/validate/{provider}/{number}', 'verifyTv')->name('tv-verify');
            Route::get('tv-preview', 'tvPreview')->name('tv-preview');
            Route::post('buy-tv', 'buyTv')->name('buy-tv');
            Route::get('tv-success', 'tvSuccess')->name('tv-success');
            // Electrcity Data
            Route::get('electricity', 'electricity')->name('electricity');
            Route::post('validate-electricity', 'electricityValidate')->name('validate-electricity');
            Route::get('electricity-preview', 'electricityPreview')->name('electricity-preview');
            Route::post('buy-electricity', 'buyElectrcity')->name('buy-electricity');
            Route::get('electricity-success', 'electricitySuccess')->name('electricity-success');
            // Betting Data
            Route::get('betting', 'betting')->name('betting');
            Route::post('validate-betting', 'bettingValidate')->name('validate-betting');
            Route::get('betting-preview', 'bettingPreview')->name('betting-preview');
            Route::post('buy-betting', 'buyBetting')->name('buy-betting');
            Route::get('betting-success', 'bettingSuccess')->name('betting-success');
        });

    });

});

// All Clients Routes Ends Here


// All Admin Routes Starts Here
Route::get('control/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('control/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('control/logout', [AdminAuthController::class, 'logout'])->name('adminLogout');

Route::group(['prefix' => 'control','middleware' => 'adminauth'], function () {
	// Admin Dashboard
	Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

});
// All Admin Routes Ends Here

require __DIR__.'/auth.php';
