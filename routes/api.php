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

Route::prefix('provider')->group(function () {
    Route::post('login', 'API\EProvider\UserAPIController@login');
    Route::post('register', 'API\EProvider\UserAPIController@providerRegister');
    Route::post('full-register/{id}', 'API\EProvider\UserAPIController@providerFullRegister');

    // Route::post('provider/register', 'API\EProvider\UserAPIControSller@providerRegister');
    Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
    Route::get('user', 'API\EProvider\UserAPIController@user');
    Route::get('logout', 'API\EProvider\UserAPIController@logout');
    Route::get('settings', 'API\EProvider\UserAPIController@settings');
    Route::get('translations', 'API\TranslationAPIController@translations');
    Route::get('supported_locales', 'API\TranslationAPIController@supportedLocales');
    Route::get('e_provider_types', 'API\EProvider\UserAPIController@serviceType');
});

Route::get('/advertisement/{service_id}','API\AdvertisementController@show');
Route::post('login', 'API\UserAPIController@login');
Route::post('get/otp', 'API\UserAPIController@getOtp');
Route::post('verify/otp', 'API\UserAPIController@verifyOtp');
Route::post('register', 'API\UserAPIController@register');
Route::post('send_reset_link_email', 'API\UserAPIController@sendResetLinkEmail');
Route::get('user', 'API\UserAPIController@user');
Route::get('logout', 'API\UserAPIController@logout');
Route::get('settings', 'API\UserAPIController@settings');
Route::get('translations', 'API\TranslationAPIController@translations');
Route::get('supported_locales', 'API\TranslationAPIController@supportedLocales');
Route::get('modules', 'API\ModuleAPIController@index');


Route::resource('e_provider_types', 'API\EProviderTypeAPIController');
Route::resource('e_providers', 'API\EProviderAPIController');
Route::resource('availability_hours', 'API\AvailabilityHourAPIController');
Route::resource('awards', 'API\AwardAPIController');
Route::resource('experiences', 'API\ExperienceAPIController');

Route::resource('faq_categories', 'API\FaqCategoryAPIController');
Route::resource('faqs', 'API\FaqAPIController');
Route::resource('custom_pages', 'API\CustomPageAPIController');

Route::resource('categories', 'API\CategoryAPIController');

Route::resource('e_services', 'API\EServiceAPIController');
Route::get('select_services', 'API\EServiceAPIController@select_services');
Route::get('services/{category_id}', 'API\EServiceAPIController@getServicesByCategory')->name('eservices.category');
Route::resource('galleries', 'API\GalleryAPIController');
Route::get('e_service_reviews/{id}', 'API\EServiceReviewAPIController@show')->name('e_service_reviews.show');
Route::get('e_service_reviews', 'API\EServiceReviewAPIController@index')->name('e_service_reviews.index');

Route::get('e_provider_reviews/{id}', 'API\EProviderReviewAPIController@show')->name('e_provider_reviews.show');
Route::get('e_provider_reviews', 'API\EProviderReviewAPIController@index')->name('e_provider_reviews.index');

Route::get('e_service_provider_reviews/{id}', 'API\EServiceProviderReviewAPIController@show')->name('e_service_provider_reviews.show');


Route::resource('currencies', 'API\CurrencyAPIController');
Route::resource('slides', 'API\SlideAPIController')->except([
    'show'
]);
Route::resource('booking_statuses', 'API\BookingStatusAPIController')->except(['show']);
Route::resource('option_groups', 'API\OptionGroupAPIController');
Route::resource('options', 'API\OptionAPIController');

Route::middleware('auth:api')->group(function () {
    Route::group(['middleware' => ['role:provider']], function () {
        Route::prefix('provider')->group(function () {
            Route::post('users/{user}', 'API\UserAPIController@update')->name('provider.update.profile');
            Route::get('dashboard', 'API\DashboardAPIController@provider');
            Route::get('e_providers', 'API\EProvider\EProviderAPIController@index')->name('provider.e_providers.index');
            Route::get('e_providers/{id}', 'API\EProvider\EProviderAPIController@show')->name('provider.e_providers.show');
            Route::resource('notifications', 'API\NotificationAPIController');
            Route::get('e_service_reviews', 'API\EServiceReviewAPIController@index')->name('provider.e_service_reviews.index');
            Route::get('e_provider_reviews', 'API\EProviderReviewAPIController@index')->name('provider.e_provider_reviews.index');
            Route::get('e_services', 'API\EServiceAPIController@index')->name('e_services.index');
            Route::put('payments/{id}', 'API\PaymentAPIController@update')->name('payments.update');
            Route::post('update-password/{user}', 'API\UserAPIController@updatePassword');
        });
    });
    Route::post('uploads/store', 'API\UploadAPIController@store');
    Route::post('uploads/clear', 'API\UploadAPIController@clear');
    Route::post('users/{user}', 'API\UserAPIController@update');
    Route::post('update-password/{user}', 'API\UserAPIController@updatePassword');

    Route::get('payments/byMonth', 'API\PaymentAPIController@byMonth')->name('payments.byMonth');
    Route::post('payments/wallets/{id}', 'API\PaymentAPIController@wallets')->name('payments.wallets');
    Route::post('payments/cash', 'API\PaymentAPIController@cash')->name('payments.cash');
    Route::resource('payment_methods', 'API\PaymentMethodAPIController')->only([
        'index'
    ]);
    Route::post('e_service_reviews', 'API\EServiceReviewAPIController@store')->name('e_service_reviews.store');
    Route::post('e_provider_reviews', 'API\EProviderReviewAPIController@store')->name('e_provider_reviews.store');
    Route::post('e_service_provider_reviews', 'API\EServiceProviderReviewAPIController@store')->name('e_service_provider_reviews.store');

    Route::resource('favorites', 'API\FavoriteAPIController');
    Route::resource('addresses', 'API\AddressAPIController');

    Route::get('notifications/count', 'API\NotificationAPIController@count');
    Route::resource('notifications', 'API\NotificationAPIController');
    Route::resource('bookings', 'API\BookingAPIController');

    Route::resource('earnings', 'API\EarningAPIController');

    Route::resource('e_provider_payouts', 'API\EProviderPayoutAPIController');

    Route::resource('coupons', 'API\CouponAPIController')->except([
        'show'
    ]);
    Route::resource('wallets', 'API\WalletAPIController')->except([
        'show', 'create', 'edit'
    ]);
    Route::get('wallet_transactions', 'API\WalletTransactionAPIController@index')->name('wallet_transactions.index');
});

/**
 * get API routes
 * get all the states and cities with the state id.
 */
Route::get('states', [App\Http\Controllers\API\StateAndCityController::class, 'states']);
Route::get('cities/{state_id}', [App\Http\Controllers\API\StateAndCityController::class, 'cities']);

