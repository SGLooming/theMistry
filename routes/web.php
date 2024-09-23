<?php
/*
 * File name: web.php
 * Last modified: 2022.04.02 at 05:07:22
 * Copyright (c) 2022
 */

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

use App\Http\Controllers\Auth\ProviderRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PayMongoController;
use App\Http\Controllers\StripeFPXController;
use App\Http\Controllers\FlutterWaveController;
use App\Http\Controllers\PayStackController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\EProviderTypeController;
use App\Http\Controllers\EProviderController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\AvailabilityHourController;
use App\Http\Controllers\EServiceController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookingStatusController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EarningController;
use App\Http\Controllers\EServiceReviewController;
use App\Http\Controllers\EProviderPayoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OptionGroupController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentStatusController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTransactionController;
use App\Http\Controllers\BookingController;
Illuminate\Support\Facades\Auth::routes();
use App\Http\Controllers\Auth\LoginController;



Route::get('login/{service}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{service}/callback', [LoginController::class, 'handleProviderCallback']);


Route::get('provider-register', [ProviderRegisterController::class, 'register']);
Route::post('provider-register', [ProviderRegisterController::class, 'register_store']);

Route::get('provier-full-registration/{id}', [ProviderRegisterController::class, 'provider_full_registratoin']);
Route::post('provier-full-registration/{id}', [ProviderRegisterController::class, 'provider_full_registratoin_store']);


// Payment Routes
Route::prefix('payments')->group(function() {
    Route::get('failed', [PayPalController::class, 'index'])->name('payments.failed');
    
    // RazorPay
    Route::prefix('razorpay')->group(function() {
        Route::get('checkout', [RazorPayController::class, 'checkout']);
        Route::post('pay-success/{bookingId}', [RazorPayController::class, 'paySuccess']);
        Route::get('/', [RazorPayController::class, 'index']);
    });
    
    // Stripe
    Route::prefix('stripe')->group(function() {
        Route::get('checkout', [StripeController::class, 'checkout']);
        Route::get('pay-success/{bookingId}/{paymentMethodId}', [StripeController::class, 'paySuccess']);
        Route::get('/', [StripeController::class, 'index']);
    });

    // PayMongo
    Route::prefix('paymongo')->group(function() {
        Route::get('checkout', [PayMongoController::class, 'checkout']);
        Route::get('processing/{bookingId}/{paymentMethodId}', [PayMongoController::class, 'processing']);
        Route::get('success/{bookingId}/{paymentIntentId}', [PayMongoController::class, 'success']);
        Route::get('/', [PayMongoController::class, 'index']);
    });

    // Stripe FPX
    Route::prefix('stripe-fpx')->group(function() {
        Route::get('checkout', [StripeFPXController::class, 'checkout']);
        Route::get('pay-success/{bookingId}', [StripeFPXController::class, 'paySuccess']);
        Route::get('/', [StripeFPXController::class, 'index']);
    });

    // FlutterWave
    Route::prefix('flutterwave')->group(function() {
        Route::get('checkout', [FlutterWaveController::class, 'checkout']);
        Route::get('pay-success/{bookingId}/{transactionId}', [FlutterWaveController::class, 'paySuccess']);
        Route::get('/', [FlutterWaveController::class, 'index']);
    });

    // PayStack
    Route::prefix('paystack')->group(function() {
        Route::get('checkout', [PayStackController::class, 'checkout']);
        Route::get('pay-success/{bookingId}/{reference}', [PayStackController::class, 'paySuccess']);
        Route::get('/', [PayStackController::class, 'index']);
    });

    // PayPal
    Route::prefix('paypal')->group(function() {
        Route::get('express-checkout', [PayPalController::class, 'getExpressCheckout'])->name('paypal.express-checkout');
        Route::get('express-checkout-success', [PayPalController::class, 'getExpressCheckoutSuccess']);
        Route::get('/', [PayPalController::class, 'index'])->name('paypal.index');
    });
});

// Firebase and Storage Routes
Route::get('firebase/sw-js', [AppSettingController::class, 'initFirebase']);
Route::get('storage/app/public/{id}/{conversion}/{filename?}', [UploadController::class, 'storage']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Uploads
    Route::post('uploads/store', [UploadController::class, 'store'])->name('medias.create');
    Route::get('users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('users/remove-media', [UserController::class, 'removeMedia']);
    Route::resource('users', UserController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Media Management (With Permission)
    Route::middleware('permission:medias')->group(function() {
        Route::get('uploads/all/{collection?}', [UploadController::class, 'all']);
        Route::get('uploads/collectionsNames', [UploadController::class, 'collectionsNames']);
        Route::post('uploads/clear', [UploadController::class, 'clear'])->name('medias.delete');
        Route::get('medias', [UploadController::class, 'index'])->name('medias');
        Route::get('uploads/clear-all', [UploadController::class, 'clearAll']);
    });

    // Permissions (With Permission)
    Route::middleware('permission:permissions.index')->group(function() {
        Route::get('permissions/role-has-permission', [PermissionController::class, 'roleHasPermission']);
        Route::get('permissions/refresh-permissions', [PermissionController::class, 'refreshPermissions']);
        Route::post('permissions/give-permission-to-role', [PermissionController::class, 'givePermissionToRole']);
        Route::post('permissions/revoke-permission-to-role', [PermissionController::class, 'revokePermissionToRole']);
    });

    // Modules
    Route::get('modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::put('modules/{id}', [ModuleController::class, 'enable'])->name('modules.enable');
    Route::post('modules/{id}/install', [ModuleController::class, 'install'])->name('modules.install');
    Route::post('modules/{id}/update', [ModuleController::class, 'update'])->name('modules.update');

    // Settings (With Permission)
    Route::middleware('permission:app-settings')->prefix('settings')->group(function() {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('customFields', CustomFieldController::class);
        Route::resource('currencies', CurrencyController::class)->except('show');
        Route::resource('taxes', TaxController::class)->except('show');
        Route::get('users/login-as-user/{id}', [UserController::class, 'loginAsUser'])->name('users.login-as-user');
        Route::patch('update', [AppSettingController::class, 'update']);
        Route::patch('translate', [AppSettingController::class, 'translate']);
        Route::get('sync-translation', [AppSettingController::class, 'syncTranslation']);
        Route::get('clear-cache', [AppSettingController::class, 'clearCache']);
        Route::get('check-update', [AppSettingController::class, 'checkForUpdates']);
        Route::get('/{type?}/{tab?}', [AppSettingController::class, 'index'])
            ->where('type', '[A-Za-z]*')->where('tab', '[A-Za-z]*')->name('app-settings');
    });

    // EProvider Routes
    Route::resource('eProviderTypes', EProviderTypeController::class)->except('show');
    Route::post('eProviders/remove-media', [EProviderController::class, 'removeMedia']);
    Route::get('eProviders/{provider_id}/services', [EProviderController::class, 'services'])->name('eProviders.services');
    Route::post('eProviders/{provider_id}/services/{service_id}', [EProviderController::class, 'services_delete'])->name('eProviders.services.delete');
    Route::resource('eProviders', EProviderController::class);
    Route::get('requestedEProviders', [EProviderController::class, 'requestedEProviders'])->name('requestedEProviders.index');

    // Advertisement Routes
    Route::post('advertisements/remove-media', [AdvertisementController::class, 'removeMedia']);
    Route::resource('advertisement', AdvertisementController::class);

    // Other Resources
    Route::resource('addresses', AddressController::class)->except('show');
    Route::resource('awards', AwardController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::resource('availabilityHours', AvailabilityHourController::class)->except('show');
    Route::post('eServices/remove-media', [EServiceController::class, 'removeMedia']);
    Route::resource('eServices', EServiceController::class)->except('show');
    Route::resource('faqCategories', FaqCategoryController::class)->except('show');
    Route::post('categories/remove-media', [CategoryController::class, 'removeMedia']);
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('bookingStatuses', BookingStatusController::class)->except('show');
    Route::post('galleries/remove-media', [GalleryController::class, 'removeMedia']);
    Route::resource('galleries', GalleryController::class)->except('show');
    Route::resource('eServiceReviews', EServiceReviewController::class)->except('show');
    Route::resource('payments', PaymentController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::post('paymentMethods/remove-media', [PaymentMethodController::class, 'removeMedia']);
    Route::resource('paymentMethods', PaymentMethodController::class)->except('show');
    Route::resource('paymentStatuses', PaymentStatusController::class)->except('show');
    Route::resource('faqs', FaqController::class)->except('show');
    Route::resource('favorites', FavoriteController::class)->except('show');
    Route::resource('notifications', NotificationController::class)->except(['create', 'store', 'update', 'edit']);
    Route::resource('bookings', BookingController::class);
    Route::resource('earnings', EarningController::class)->except(['show', 'edit', 'update']);
    Route::get('eProviderPayouts/create/{id}', [EProviderPayoutController::class, 'create'])->name('eProviderPayouts.create');
    Route::resource('eProviderPayouts', EProviderPayoutController::class)->except(['show', 'edit', 'update', 'create']);
    Route::resource('optionGroups', OptionGroupController::class)->except('show');
    Route::post('options/remove-media', [OptionController::class, 'removeMedia']);
    Route::resource('options', OptionController::class)->except('show');
    Route::resource('coupons', CouponController::class)->except('show');
    Route::post('slides/remove-media', [SlideController::class, 'removeMedia']);
    Route::resource('slides', SlideController::class)->except('show');
    Route::resource('customPages', CustomPageController::class);
    Route::resource('wallets', WalletController::class)->except('show');
    Route::resource('walletTransactions', WalletTransactionController::class)->except(['show', 'edit', 'update', 'destroy']);
});
