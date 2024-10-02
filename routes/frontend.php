<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ContactPage;
use App\Livewire\HomePage;
use App\Livewire\Login;
use App\Livewire\ProductDetail;
use Livewire\Livewire;

// Homepage
Route::get('/', HomePage::class)->name('home');

// Contact Us
Route::get('/contact-us', ContactPage::class)->name('contact-us');

Route::get('/product-detail/{product_slug}', ProductDetail::class)->name('product-detail');

Route::get('login', Login::class)->name('login');
Route::post('login', [Login::class, 'authenticate'])->name('authenticate');
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('/locale/{locale}', function ($locale) {
    session(['locale' => $locale]);
    return redirect()->back();
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(url('/') . '/livewire/livewire.js', $handle);
});
