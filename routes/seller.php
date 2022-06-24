<?php

use App\Http\Controllers\AizUploadController;
use App\Addons\Multivendor\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Addons\Multivendor\Http\Controllers\Admin\SellerPackageController as AdminSellerPackageController;
use App\Addons\Multivendor\Http\Controllers\Admin\SellerPayoutController as AdminSellerPayoutController;
use App\Addons\Multivendor\Http\Controllers\Admin\CommissionController as AdminCommissionController;
use App\Addons\Multivendor\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Addons\Multivendor\Http\Controllers\Seller\SellerController;
use App\Addons\Multivendor\Http\Controllers\Seller\ShopController;
use App\Addons\Multivendor\Http\Controllers\Seller\CommissionController;
use App\Addons\Multivendor\Http\Controllers\Seller\CouponController;
use App\Addons\Multivendor\Http\Controllers\Seller\SellerPackageController;
use App\Addons\Multivendor\Http\Controllers\Seller\SellerPayoutController; 
use App\Addons\Multivendor\Http\Controllers\Seller\ConversationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
|
| Here is where you can register seller routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => 'seller',
    'middleware' => ['auth', 'seller'],
    'as' => 'seller.'
], function () {


    Route::get('/', [SellerController::class, 'seller_dashboard'])->name('dashboard');
    Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [SellerController::class, 'profile_update'])->name('profile.update');
    Route::post('/language', [LanguageController::class, 'changeLanguage'])->name('language.change');

    // Shop Setting
    Route::resource('/shop', ShopController::class); 

    // Seller products
    Route::group(['prefix' => 'product'], function () {
        Route::get('', [SellerController::class, 'seller_products_list'])->name('products');
        Route::get('/upload', [SellerController::class, 'show_product_upload_form'])->name('products.create');
        Route::post('/store', [SellerController::class, 'seller_product_store'])->name('product.store');
        Route::get('/{id}/edit', [SellerController::class, 'show_product_edit_form'])->name('products.edit');
        Route::post('/product/update/{id}', [SellerController::class, 'seller_product_update'])->name('product.update');
        Route::get('/{id}', [SellerController::class, 'seller_product_show'])->name('product.show');
        Route::post('/published', [SellerController::class, 'seller_product_published'])->name('product.published');
        Route::get('/duplicate/{id}', [SellerController::class, 'seller_product_duplicate'])->name('product.duplicate');
        Route::get('/destroy/{id}', [SellerController::class, 'seller_product_destroy'])->name('product.destroy');


        Route::post('/new-attribte', [ProductController::class, 'new_attribute'])->name('product.new_attribute');
        Route::post('/get-attribte-value', [ProductController::class, 'get_attribute_values'])->name('product.get_attribute_values');
        Route::post('/new-option', [ProductController::class, 'new_option'])->name('product.new_option');
        Route::post('/get-option-choices', [ProductController::class, 'get_option_choices'])->name('product.get_option_choices');
        Route::post('/sku-combination', [ProductController::class, 'sku_combination'])->name('product.sku_combination');
    });

    // Seller packages
    Route::get('/select-package', [SellerPackageController::class, 'select_package'])->name('package_select');
    Route::post('/packages/purchase', [SellerPackageController::class, 'package_purchase'])->name('packages.purchase');
    Route::get('/packages/purchase-history', [SellerPackageController::class, 'package_purchase_history'])->name('package_purchase_history');

    //coupons
    Route::resource('coupons', CouponController::class)->names('coupons');
    Route::post('/coupon/get_form', [CouponController::class, 'get_coupon_form'])->name('coupons.get_coupon_form');
    Route::post('/coupon/get_form_edit', [CouponController::class, 'get_coupon_form_edit'])->name('coupons.get_coupon_form_edit');
    Route::get('/coupon/destroy/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
 
    # conversation
    Route::controller(ConversationController::class)->group(function () {
        Route::get('/product-querries', 'index')->name('querries.index');
        Route::post('/new-query', 'storeMessage')->name('querries.store');
        Route::post('/product-querries/refresh', 'refresh')->name('querries.refresh');
        Route::get('/product-querries/show/{id}', 'show')->name('querries.show');
    }); 

    // Orders
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::get('/orders/show/{id}', [SellerController::class, 'orders_show'])->name('orders_show');
    Route::get('/orders/print/{order_id}', [InvoiceController::class, 'invoice_print'])->name('orders.invoice.print');
    Route::get('/orders/invoice/{order_id}', [InvoiceController::class, 'seller_invoice_download'])->name('orders.invoice.download');
    Route::post('/orders/update_delivery_status', [OrderController::class, 'update_delivery_status'])->name('orders.update_delivery_status');
    Route::post('/orders/update_payment_status', [OrderController::class, 'update_payment_status'])->name('orders.update_payment_status');
    Route::post('/orders/add-tracking-information', [OrderController::class, 'add_tracking_information'])->name('orders.add_tracking_information');

    // Seller payouts
    Route::post('/payouts/store-request', [SellerPayoutController::class, 'store_withdraw_request'])->name('payouts.request.store');
    Route::get('/payouts/request', [SellerPayoutController::class, 'payout_requests'])->name('payouts.request');
    Route::resource('/payouts', SellerPayoutController::class)->names('payouts');

    Route::get('/payout-settings', [SellerPayoutController::class, 'payout_settings'])->name('payout_settings');
    Route::post('/payout-settings/update', [SellerPayoutController::class, 'payout_settings_update'])->name('payout_settings.update');

    Route::get('/commission-log', [CommissionController::class, 'commission_history'])->name('commission_log.index');

    //Reviews
    Route::get('/product-reviews', [SellerController::class, 'seller_product_reviews'])->name('product_reviews.index');

    // Uploaded Files
    Route::get('/uploaded-files', [AizUploadController::class, 'seller_index'])->name('uploaded_files');
    Route::get('/uploaded-files/create', [AizUploadController::class, 'create'])->name('uploaded_files.create');
    Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class, 'destroy'])->name('uploaded-files.destroy');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'admin'],
    'as' => 'admin.'
], function () {
    Route::get('/all-sellers', [AdminSellerController::class, 'all_sellers'])->name('all_sellers');
    Route::get('/seller-create', [AdminSellerController::class, 'seller_create'])->name('seller.create');
    Route::post('/seller-store', [AdminSellerController::class, 'seller_store'])->name('seller.store');
    Route::get('/seller-edit/{id}', [AdminSellerController::class, 'seller_edit'])->name('seller.edit');
    Route::post('/seller-update', [AdminSellerController::class, 'seller_update'])->name('seller.update');
    Route::post('/sellers/approval', [AdminSellerController::class, 'update_seller_approval'])->name('sellers.approval');
    Route::post('/shop/publish', [AdminSellerController::class, 'update_shop_publish'])->name('shop.publish');
    Route::post('/sellers/profile_modal', [AdminSellerController::class, 'profile_modal'])->name('sellers.profile_modal');
    Route::post('/sellers/payment_modal', [AdminSellerController::class, 'payment_modal'])->name('sellers.payment_modal');
    Route::get('/sellers/destroy/{id}', [AdminSellerController::class, 'seller_destroy'])->name('seller.destroy');
    Route::get('/sellers/login/{id}', [AdminSellerController::class, 'login_as_seller'])->name('seller.login_as_seller');


    Route::get('/seller-products', [AdminSellerController::class, 'seller_products'])->name('seller_products.index');
    Route::get('/seller-orders', [AdminSellerController::class, 'seller_orders'])->name('seller_orders.index');

    Route::get('/sellers/payout-requests', [AdminSellerPayoutController::class, 'payout_requests'])->name('all_payout_requests');
    Route::post('/sellers/payout_request/payment_modal', [AdminSellerPayoutController::class, 'payment_modal'])->name('payout_request.payment_modal');
    Route::post('/pay_to_seller', [AdminSellerPayoutController::class, 'pay_to_seller'])->name('pay_to_seller');
    Route::get('/sellers/payout-history', [AdminSellerPayoutController::class, 'index'])->name('seller_payments_history');

    Route::get('/sellers/commission-log', [AdminCommissionController::class, 'commission_history'])->name('commission_log.index');

    // Seller package
    Route::resource('seller-packages', AdminSellerPackageController::class)->names('seller_packages');
    Route::get('/seller-packages/edit/{id}', [AdminSellerPackageController::class, 'edit'])->name('seller_packages.edit');
    Route::get('/seller-packages/destroy/{id}', [AdminSellerPackageController::class, 'destroy'])->name('seller_packages.destroy');
    Route::get('/seller/package-payments', [AdminSellerPackageController::class, 'package_purchase_history'])->name('package_purchase_history');


    Route::get('/shop-setting', [AdminShopController::class, 'shop_setting'])->name('shop_setting.index');
    Route::patch('/shop-setting/{id}', [AdminShopController::class, 'shop_setting_update'])->name('shop_setting.update');
});

Route::get('/seller-package-validation-check', [AdminSellerPackageController::class, 'check_seller_package_validation'])->name('seller_packages.unpublish_products');
