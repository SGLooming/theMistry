<?php
/*
 * File name: api.php
 * Last modified: 2022.04.01 at 23:10:55
 * Copyright (c) 2022
 */

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

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\AddressAPIController;
use App\Http\Controllers\API\AwardAPIController;
use App\Http\Controllers\API\AvailabilityHourAPIController;
use App\Http\Controllers\API\BookingAPIController;
use App\Http\Controllers\API\BookingStatusAPIController;
use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\CouponAPIController;
use App\Http\Controllers\API\CurrencyAPIController;
use App\Http\Controllers\API\CustomPageAPIController;
use App\Http\Controllers\API\DashboardAPIController;
use App\Http\Controllers\API\EarningAPIController;
use App\Http\Controllers\API\EProviderAPIController;
use App\Http\Controllers\API\EProviderPayoutAPIController;
use App\Http\Controllers\API\EProviderReviewAPIController;
use App\Http\Controllers\API\EServiceAPIController;
use App\Http\Controllers\API\EServiceProviderReviewAPIController;
use App\Http\Controllers\API\EServiceReviewAPIController;
use App\Http\Controllers\API\EProviderTypeAPIController;
use App\Http\Controllers\API\ExperienceAPIController;
use App\Http\Controllers\API\FaqAPIController;
use App\Http\Controllers\API\FaqCategoryAPIController;
use App\Http\Controllers\API\FavoriteAPIController;
use App\Http\Controllers\API\GalleryAPIController;
use App\Http\Controllers\API\ModuleAPIController;
use App\Http\Controllers\API\NotificationAPIController;
use App\Http\Controllers\API\OptionAPIController;
use App\Http\Controllers\API\OptionGroupAPIController;
use App\Http\Controllers\API\PaymentAPIController;
use App\Http\Controllers\API\PaymentMethodAPIController;
use App\Http\Controllers\API\SlideAPIController;
use App\Http\Controllers\API\TranslationAPIController;
use App\Http\Controllers\API\UploadAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\WalletAPIController;
use App\Http\Controllers\API\WalletTransactionAPIController;

Route::prefix('provider')->group(function () {
    Route::post('login', [UserAPIController::class, 'login']);
    Route::post('register', [UserAPIController::class, 'providerRegister']);
    Route::post('full-register/{id}', [UserAPIController::class, 'providerFullRegister']);
    
    Route::post('send_reset_link_email', [UserAPIController::class, 'sendResetLinkEmail']);
    Route::get('user', [UserAPIController::class, 'user']);
    Route::get('logout', [UserAPIController::class, 'logout']);
    Route::get('settings', [UserAPIController::class, 'settings']);
    Route::get('translations', [TranslationAPIController::class, 'translations']);
    Route::get('supported_locales', [TranslationAPIController::class, 'supportedLocales']);
    Route::get('e_provider_types', [UserAPIController::class, 'serviceType']);
});

Route::get('/advertisement/{service_id}', [AdvertisementController::class, 'show']);
Route::post('login', [UserAPIController::class, 'login']);
Route::post('get/otp', [UserAPIController::class, 'getOtp']);
Route::post('verify/otp', [UserAPIController::class, 'verifyOtp']);
Route::post('register', [UserAPIController::class, 'register']);
Route::post('send_reset_link_email', [UserAPIController::class, 'sendResetLinkEmail']);
Route::get('user', [UserAPIController::class, 'user']);
Route::get('logout', [UserAPIController::class, 'logout']);
Route::get('settings', [UserAPIController::class, 'settings']);
Route::get('translations', [TranslationAPIController::class, 'translations']);
Route::get('supported_locales', [TranslationAPIController::class, 'supportedLocales']);
Route::get('modules', [ModuleAPIController::class, 'index']);

Route::resource('e_provider_types', EProviderTypeAPIController::class);
Route::resource('e_providers', EProviderAPIController::class);
Route::resource('availability_hours', AvailabilityHourAPIController::class);
Route::resource('awards', AwardAPIController::class);
Route::resource('experiences', ExperienceAPIController::class);

Route::resource('faq_categories', FaqCategoryAPIController::class);
Route::resource('faqs', FaqAPIController::class);
Route::resource('custom_pages', CustomPageAPIController::class);

Route::resource('categories', CategoryAPIController::class);

Route::resource('e_services', EServiceAPIController::class);
Route::get('select_services', [EServiceAPIController::class, 'select_services']);
Route::get('services/{category_id}', [EServiceAPIController::class, 'getServicesByCategory'])->name('eservices.category');
Route::resource('galleries', GalleryAPIController::class);
Route::get('e_service_reviews/{id}', [EServiceReviewAPIController::class, 'show'])->name('e_service_reviews.show');
Route::get('e_service_reviews', [EServiceReviewAPIController::class, 'index'])->name('e_service_reviews.index');

Route::get('e_provider_reviews/{id}', [EProviderReviewAPIController::class, 'show'])->name('e_provider_reviews.show');
Route::get('e_provider_reviews', [EProviderReviewAPIController::class, 'index'])->name('e_provider_reviews.index');

Route::get('e_service_provider_reviews/{id}', [EServiceProviderReviewAPIController::class, 'show'])->name('e_service_provider_reviews.show');

Route::resource('currencies', CurrencyAPIController::class);
Route::resource('slides', SlideAPIController::class)->except(['show']);
Route::resource('booking_statuses', BookingStatusAPIController::class)->except(['show']);
Route::resource('option_groups', OptionGroupAPIController::class);
Route::resource('options', OptionAPIController::class);

Route::middleware('auth:api')->group(function () {
    Route::group(['middleware' => ['role:provider']], function () {
        Route::prefix('provider')->group(function () {
            Route::post('users/{user}', [UserAPIController::class, 'update'])->name('provider.update.profile');
            Route::get('dashboard', [DashboardAPIController::class, 'provider']);
            Route::get('e_providers', [EProviderAPIController::class, 'index'])->name('provider.e_providers.index');
            Route::get('e_providers/{id}', [EProviderAPIController::class, 'show'])->name('provider.e_providers.show');
            Route::resource('notifications', NotificationAPIController::class);
            Route::get('e_service_reviews', [EServiceReviewAPIController::class, 'index'])->name('provider.e_service_reviews.index');
            Route::get('e_provider_reviews', [EProviderReviewAPIController::class, 'index'])->name('provider.e_provider_reviews.index');
            Route::get('e_services', [EServiceAPIController::class, 'index'])->name('e_services.index');
            Route::put('payments/{id}', [PaymentAPIController::class, 'update'])->name('payments.update');
            Route::post('update-password/{user}', [UserAPIController::class, 'updatePassword']);
        });
    });
    
    Route::post('uploads/store', [UploadAPIController::class, 'store']);
    Route::post('uploads/clear', [UploadAPIController::class, 'clear']);
    Route::post('users/{user}', [UserAPIController::class, 'update']);
    Route::post('update-password/{user}', [UserAPIController::class, 'updatePassword']);
    
    Route::get('payments/byMonth', [PaymentAPIController::class, 'byMonth'])->name('payments.by.month');
    Route::post('payments/wallets/{id}', [PaymentAPIController::class, 'wallets'])->name('payments.wallets');
    Route::post('payments/cash', [PaymentAPIController::class, 'cash'])->name('payments.cash');
    Route::resource('payment_methods', PaymentMethodAPIController::class)->only(['index']);
    
    Route::post('e_service_reviews', [EServiceReviewAPIController::class, 'store'])->name('e_service_reviews.store');
    Route::post('e_provider_reviews', [EProviderReviewAPIController::class, 'store'])->name('e_provider_reviews.store');
    Route::post('e_service_provider_reviews', [EServiceProviderReviewAPIController::class, 'store'])->name('e_service_provider_reviews.store');

    Route::resource('favorites', FavoriteAPIController::class);
    Route::resource('addresses', AddressAPIController::class);

    Route::get('notifications/count', [NotificationAPIController::class, 'count']);
    Route::resource('notifications', NotificationAPIController::class);
    Route::resource('bookings', BookingAPIController::class);

    Route::resource('earnings', EarningAPIController::class);
    Route::resource('e_provider_payouts', EProviderPayoutAPIController::class);

    Route::resource('coupons', CouponAPIController::class)->except(['show']);
    Route::resource('wallets', WalletAPIController::class)->except(['show', 'create', 'edit']);
    Route::get('wallet_transactions', [WalletTransactionAPIController::class, 'index'])->name('wallet_transactions.index');
});


/**
 * get API routes
 * get all the states and cities with the state id.
 */
Route::get('states', [App\Http\Controllers\API\StateAndCityController::class, 'states']);
Route::get('cities/{state_id}', [App\Http\Controllers\API\StateAndCityController::class, 'cities']);

