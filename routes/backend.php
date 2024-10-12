<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SiteBannerController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductUnitController;
use App\Http\Controllers\Backend\TranslationController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\CurrencyController;
use App\Http\Controllers\Backend\HomePageSettingsController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\PaymentMethodController;
use App\Http\Controllers\Backend\InquiryController;
use App\Http\Controllers\Backend\NotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SettingController;

Auth::routes();

Route::get('/', [HomeController::class, 'root'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('site-banner', SiteBannerController::class);
    Route::resource('product', ProductController::class);
    Route::resource('product-unit', ProductUnitController::class);
    Route::resource('translation', TranslationController::class);
    Route::resource('order', OrderController::class);
    Route::resource('currency', CurrencyController::class);
    Route::resource('language', LanguageController::class);
    Route::resource('payment-method', PaymentMethodController::class);
    Route::resource('inquiry', InquiryController::class);
    Route::resource('notification', NotificationController::class);
    
    // Corrected route for changing the read status of notifications.
    Route::post('notification/{notification}/{status}', [NotificationController::class, 'ChangeMarkAsReadUnRead'])->name('notification.markas');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('update-settings', [SettingController::class, 'update'])->name('settings.update');

    Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
        Route::delete('image/{image}/remove', [ProductController::class, 'destroyImage'])->name('image.remove');
        Route::post('image/{image}/make-primary', [ProductController::class, 'makePrimaryImage'])->name('image.make-primary');
    });

    Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
        Route::post('status/{order}', [OrderController::class, 'updateStatus'])->name('update.status');
        Route::post('change-status', [OrderController::class, 'changeStatus'])->name('change.status');

        Route::group(['prefix' => 'bulk', 'as' => 'bulk.'], function() {
            Route::post('export', [OrderController::class, 'bulkExport'])->name('export');
            Route::post('update', [OrderController::class, 'bulkUpdate'])->name('update');
        });
    });

    Route::group(['prefix' => 'home-settings', 'as' => 'home-settings.'], function() {
        Route::get('index', [HomePageSettingsController::class, 'index'])->name('index');
        Route::post('store', [HomePageSettingsController::class, 'store'])->name('store');
        Route::post('banner-store', [HomePageSettingsController::class, 'bannerStore'])->name('banner-store');
    });
});
