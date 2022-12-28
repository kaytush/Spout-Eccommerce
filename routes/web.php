<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\EtemplateController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PricingController;
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
            // User Profile & Settings
            Route::get('user-profile', 'profile')->name('user.profile');
            Route::get('account-settings', 'accountSettings')->name('account-settings');
            Route::post('update-profile', 'profileUpdate')->name('update-profile');
            Route::post('verify-bvn', 'verifyBVN')->name('verify-bvn');
            Route::post('change-password', 'submitPassword')->name('change-password');
        });
        Route::group(['middleware' => 'CompleteProfile'], function () {
            // User Controller
            Route::controller(UserController::class)->group(function () {
                // User Dashboard
                Route::get('dashboard', 'dashboard')->name('dashboard');
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

});

// All Clients Routes Ends Here


// All Admin Routes Starts Here
Route::get('control/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('control/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('control/logout', [AdminAuthController::class, 'logout'])->name('adminLogout');

Route::group(['prefix' => 'control','middleware' => 'adminauth'], function () {
	// Admin Dashboard
	Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

	// System General Settings
	Route::get('settings', [AdminController::class, 'settings'])->name('settings');
	Route::post('settings', [AdminController::class, 'UpdateSettings'])->name('UpdateSettings');
	Route::post('other-settings', [AdminController::class, 'UpdateOtherSettings'])->name('UpdateOtherSettings');

	// Pricing Settings
	Route::get('airtime-setting', [PricingController::class, 'airimeSetting'])->name('airtime-setting');
	Route::post('settings', [PricingController::class, 'UpdateSettings'])->name('UpdateSettings');
	Route::post('other-settings', [PricingController::class, 'UpdateOtherSettings'])->name('UpdateOtherSettings');

    // Frontend CMS
    Route::get('teams', [AdminController::class, 'teams'])->name('teams');
    Route::post('/create-team', [AdminController::class, 'newTeam'])->name('create-team');
    Route::post('/edit-team', [AdminController::class, 'editTeam'])->name('edit-team');
    Route::get('/actteam/{id}', [AdminController::class, 'actTeam'])->name('activate.team');
    Route::get('/deactteam/{id}', [AdminController::class, 'deactTeam'])->name('deactivate.team');
    Route::get('partners', [AdminController::class, 'partners'])->name('partners');
    Route::post('/create-partner', [AdminController::class, 'newPartner'])->name('create-partner');
    Route::post('/edit-partner', [AdminController::class, 'editPartner'])->name('edit-partner');
    Route::get('/actpartner/{id}', [AdminController::class, 'actPartner'])->name('activate.partner');
    Route::get('/deactpartner/{id}', [AdminController::class, 'deactPartner'])->name('deactivate.partner');
    Route::get('testimonials', [AdminController::class, 'testimonials'])->name('testimonials');
    Route::post('/create-testimonial', [AdminController::class, 'newTestimonial'])->name('create-testimonial');
    Route::post('/edit-testimonial', [AdminController::class, 'editTestimonial'])->name('edit-testimonial');
    Route::get('/acttestimonial/{id}', [AdminController::class, 'actTestimonial'])->name('activate.testimonial');
    Route::get('/deacttestimonial/{id}', [AdminController::class, 'deactTestimonial'])->name('deactivate.testimonial');
    Route::get('counters', [AdminController::class, 'counters'])->name('counters');
    Route::post('/edit-counter', [AdminController::class, 'editCounter'])->name('edit-counter');
    Route::get('about-section-one', [AdminController::class, 'aboutSecOne'])->name('about-sec-one');
    Route::post('about-section-one', [AdminController::class, 'UpdateAboutUs'])->name('about-sec-one-update');
    Route::get('about-section-two', [AdminController::class, 'aboutSecTwo'])->name('about-sec-two');
    Route::post('about-section-two', [AdminController::class, 'UpdateAboutUs'])->name('about-sec-two-update');
    Route::get('home-header', [AdminController::class, 'homeHeader'])->name('home-header');
    Route::post('home-header', [AdminController::class, 'UpdatehomeHeader'])->name('home-header-update');
    Route::get('terms-and-conditions', [AdminController::class, 'terms'])->name('home-terms');
    Route::post('terms-and-conditions', [AdminController::class, 'UpdateTerms'])->name('home-terms-update');
    Route::get('privacy-policy', [AdminController::class, 'privacy'])->name('home-privacy');
    Route::post('privacy-policy', [AdminController::class, 'UpdatePrivacy'])->name('home-privacy-update');

    //Manage FAQs
    Route::get('faqs', [AdminController::class, 'faqs'])->name('faqs');
    Route::post('faqs-create', [AdminController::class, 'createFaqs'])->name('faqs-create');
    Route::post('faqs-edit/{id}', [AdminController::class, 'updateFaqs'])->name('faqs-update');
    Route::get('faqs-delete/{id}', [AdminController::class, 'deleteFaqs'])->name('faqs-delete');

    //Frontend Blog System
    Route::get('blog-category', [BlogController::class, 'blogCat'])->name('blog-cat');
    Route::post('create-blog-category', [BlogController::class, 'createBlogCat'])->name('create.blog.cat');
	Route::get('/act-blog-cat/{id}', [BlogController::class, 'actBlogCat'])->name('activate.blog.cat');
    Route::get('/deact-blog-cat/{id}', [BlogController::class, 'deactBlogCat'])->name('deactivate.blog.cat');
    Route::get('blog-list', [BlogController::class, 'blogList'])->name('blog-list');
    Route::get('blog-new', [BlogController::class, 'blogNew'])->name('blog-new');
    Route::post('new-post', [BlogController::class, 'newPost'])->name('new-post');
    Route::get('blog-edit/{id}', [BlogController::class, 'blogEdit'])->name('blog-edit');
    Route::post('edit-post', [BlogController::class, 'editPost'])->name('edit-post');
    Route::get('/act-blog/{id}', [BlogController::class, 'actBlogPost'])->name('activate.blog.post');
    Route::get('/deact-blog/{id}', [BlogController::class, 'deactBlogPost'])->name('deactivate.blog.post');

	//Admin Profile & Logs
	Route::get('profile', [AdminController::class, 'profile'])->name('profile');
	Route::get('profile-picture', [AdminController::class, 'profilePic'])->name('profile-pic');
	Route::post('profile-image', [AdminController::class, 'profileImage'])->name('profile-image');
	Route::post('profile-personal', [AdminController::class, 'profilePersonal'])->name('profile.personal');
	Route::post('profile-address', [AdminController::class, 'profileAddress'])->name('profile.address');
	Route::get('activity-logs', [AdminController::class, 'accountActivity'])->name('account-activity');
	Route::get('security-settings', [AdminController::class, 'securitySettings'])->name('security-settings');
	Route::get('change-password', [AdminController::class, 'changePassword'])->name('change-password');
	Route::post('change-password', [AdminController::class, 'submitPassword'])->name('submit-new-password');
	Route::get('/status/update', [AdminController::class, 'updateActiveLog'])->name('update.activity.on.off');

	//Bills
	Route::get('bill-history', [UserManageController::class, 'allBills'])->name('bill-history');
	Route::get('check-internet-status/{orderNo}/{reference}', [BillsController::class, 'checkInternetStatus'])->name('check-internet-status');
	Route::get('check-betting-status/{orderNo}/{reference}', [BillsController::class, 'checkBettingStatus'])->name('check-betting-status');
	Route::get('refund-client-bill/{id}', [BillsController::class, 'refundClientBill'])->name('refund-client-bill');
	Route::get('update-bill-status/{id}/{status}', [BillsController::class, 'updateBillStatus'])->name('update-bill-status');
    Route::any('transaction-search', [UserManageController::class, 'billSearch'])->name('bills.search');
    Route::get('user-bill-cal/{id}', [UserManageController::class, 'UserbillCal'])->name('user-bill-cal');

    //Airtime to Cash
	Route::get('list-conversion', [UserManageController::class, 'allConversion'])->name('list-conversion');
	Route::get('list-pending-conversion', [UserManageController::class, 'pendingConversion'])->name('list-pending-conversion');
	Route::get('approve-conversion/{id}', [UserManageController::class, 'approveAirtimeConvert'])->name('approve-conversion');

    //User Transaction logs
	Route::get('deposit-history', [UserManageController::class, 'depositHistory'])->name('deposit-history');
	Route::get('transaction-history', [UserManageController::class, 'transactionHistory'])->name('transaction-history');
	Route::get('transfer-history', [UserManageController::class, 'transferHistory'])->name('transfer-history');
	Route::get('convert-airtime-history', [UserManageController::class, 'convertAirtimeHistory'])->name('convert-airtime-history');


	//Payment Settings
    Route::get('payment-settings', [AdminController::class, 'paymentSettings'])->name('payment-settings');
    Route::post('update-online-gateway', [AdminController::class, 'updateOnGate'])->name('update.online.gateway');
    Route::post('update-offline-gateway', [AdminController::class, 'updateOffGate'])->name('update.offline.gateway');

	//State Settings
    Route::get('/state', [StateController::class, 'show'])->name('state');
    Route::get('/actstate/{id}', [StateController::class, 'act'])->name('activate.state');
    Route::get('/deactstate/{id}', [StateController::class, 'deact'])->name('deactivate.state');

	//Email Template Configuration
    Route::get('/email-template', [EtemplateController::class, 'index'])->name('email.template');
    Route::post('/template-update', [EtemplateController::class, 'update'])->name('template.update');

	//User - Client  Settings
    Route::get('/clients', [UserManageController::class, 'index'])->name('clients');
    Route::get('/client-details/{id}', [UserManageController::class, 'clientDetails'])->name('client.details');
    Route::post('/client-sendmail', [UserManageController::class, 'clientSendmail'])->name('client.sendmail');
    Route::post('/client-fund', [UserManageController::class, 'clientFund'])->name('client.fund');
    Route::get('/mconfirm-flpayment/{trx}', [UserManageController::class, 'approveFlPayment'])->name('mconfirm-flpayment');
    Route::get('/client-upgrade/{id}', [UserManageController::class, 'upgradeClient'])->name('client.upgrade');
    Route::get('/actclient/{id}', [UserManageController::class, 'act'])->name('activate.client');
    Route::get('/deactclient/{id}', [UserManageController::class, 'deact'])->name('deactivate.client');
    Route::get('/deacttfa/{id}', [UserManageController::class, 'deacttfa'])->name('deactivate.client-tfa');

    //Subscriber Management
    Route::get('/subscribers', [SubscriberController::class, 'manageSubscribers'])->name('manage.subscribers');
    Route::get('/update-subscriber/{id}', [SubscriberController::class, 'updateSubscriber'])->name('update.subscriber');
    Route::get('/send-email', [SubscriberController::class, 'sendMail'])->name('send.mail.subscriber');
    Route::post('/send-email-now', [SubscriberController::class, 'sendMailsubscriber'])->name('send.email.now');
});
// All Admin Routes Ends Here

require __DIR__.'/auth.php';
