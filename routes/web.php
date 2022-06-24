<?php

use App\Http\Controllers\Payment\FlutterwavePaymentController;
use App\Http\Controllers\Payment\PaypalPaymentController;
use App\Http\Controllers\Payment\PaystackPaymentController;
use App\Http\Controllers\Payment\PaytmPaymentController;
use App\Http\Controllers\Payment\SSLCommerzPaymentController;
use App\Http\Controllers\Payment\StripePaymentController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Payment\RazorpayPaymentController;

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


// Route::get('/offline', 'HomeController@index')->name('offline');

Route::group(['prefix' => 'payment'], function(){

    Route::any('/{gateway}/pay', [PaymentController::class,'payment_initialize']);

    // stripe
    Route::any('/stripe/create-session', [StripePaymentController::class,'create_checkout_session'])->name('stripe.get_token');
    Route::get('/stripe/success', [StripePaymentController::class,'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class,'cancel'])->name('stripe.cancel');

    // paypal
    Route::get('/paypal/success', [PaypalPaymentController::class,'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [PaypalPaymentController::class,'cancel'])->name('paypal.cancel');

    //sslcommerz
    Route::any('/sslcommerz/success', [SSLCommerzPaymentController::class,'success'])->name('sslcommerz.success');
    Route::any('/sslcommerz/fail', [SSLCommerzPaymentController::class,'fail'])->name('sslcommerz.fail');
    Route::any('/sslcommerz/cancel', [SSLCommerzPaymentController::class,'cancel'])->name('sslcommerz.cancel');

    //paystack
    Route::any('/paystack/callback', [PaystackPaymentController::class,'return'])->name('paystack.return');

    //paytm
    Route::any('/paytm/callback', [PaytmPaymentController::class,'callback'])->name('paytm.callback');

    //flutterwave
    Route::any('/flutterwave/callback', [FlutterwavePaymentController::class,'callback'])->name('flutterwave.callback');

    // razorpay
    Route::post('razorpay/payment', [RazorpayPaymentController::class,'payment'])->name('razorpay.payment');
});

Route::any('/social-login/redirect/{provider}', [LoginController::class,'redirectToProvider'])->name('social.login');
Route::get('/social-login/{provider}/callback', [LoginController::class,'handleProviderCallback'])->name('social.callback');


Route::get('/product/{slug}', [HomeController::class,'index'])->name('product');
Route::get('/category/{slug}', [HomeController::class,'index'])->name('products.category');

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('{slug}', [HomeController::class,'index'])->where('slug','.*');






// Route::get('/demo/cron_1', 'DemoController@cron_1');
// Route::get('/demo/cron_2', 'DemoController@cron_2');


