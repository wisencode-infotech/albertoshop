<?php

use App\Helpers\CartHelper;
use App\Helpers\WishlistHelper;
use Illuminate\Support\Facades\Route;
use App\Livewire\ContactPage;
use App\Livewire\HomePage;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\ForgotPassword;
use App\Livewire\ResetPassword;
use App\Livewire\Logout;
use App\Livewire\ProductDetail;
use App\Livewire\CartPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;
use Illuminate\Support\Facades\Cache;
use App\Livewire\GuestCheckout;
use App\Livewire\Checkout;
use App\Http\Middleware\RedirectIfNotLoggedIn;
use App\Livewire\OrderDetails;
use App\Livewire\MyOrders;
use App\Livewire\Profile;
use App\Livewire\MyWishList;

// Homepage
Route::get('/', HomePage::class)->name('home');

// Contact Us
Route::get('/contact-us', ContactPage::class)->name('contact-us');

Route::get('/product-detail/{product_slug}', ProductDetail::class)->name('product-detail');

Route::get('/cart', CartPage::class)->name('cart');

Route::get('login', Login::class)->name('login');
Route::post('login', [Login::class, 'authenticate'])->name('authenticate');
Route::get('logout', [Logout::class, 'logout'])->name('logout');

Route::get('register', Register::class)->name('register');
Route::get('forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');

Route::get('/guest-checkout', GuestCheckout::class)->name('guest.checkout');

Route::middleware(RedirectIfNotLoggedIn::class)->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/my-wishlist', MyWishList::class)->name('my-wishlist');
    Route::get('/my-orders', MyOrders::class)->name('my-orders');
    Route::get('/checkout', Checkout::class)->name('checkout');
});

Route::prefix('orders')->name('orders.')->group(function () {
    Route::prefix('{order}')->group(function () {
        Route::get('details', OrderDetails::class)->name('details');
    });
});

Route::get('/locale/{locale}', function (string $locale) {
    Session::put('app_locale', $locale);

    return redirect()->back();
})->name('change.locale');

Route::get('/currency/{currency}', function (string $currency) {

    $cache_key = "user.currency";

    Cache::forget($cache_key);

    Session::put('user_currency_code', $currency);

    return redirect()->back();
})->name('change.currency');


Route::get('/fetch-session-preferences', function () {
    return response()->json([
        'cart' => CartHelper::items(),
        'wishlist' => WishlistHelper::items()
    ]);
})->name('fetch-session-preferences');

Route::post('/sync-session-preferences', function (Request $request) {

    $cart = $request->cart ?? [];
    $cart_updated = $wishlist_updated = false;

    $wishlist = $request->wishlist ?? [];

    $stored_shopping_cart = CartHelper::items();
    $stored_wishlist = WishlistHelper::items();

    if (!empty($cart) && empty($stored_shopping_cart)) {
        Session::put('cart', $cart ?? []);
        $cart_updated = true;
    }

    if (!empty($wishlist) && empty($stored_wishlist)) {
        Session::put('wishlist', $wishlist ?? []);
        $wishlist_updated = true;
    }

    return response()->json([
        'cart' => $stored_shopping_cart,
        'wishlist' => $stored_wishlist,
        'cart_updated' => $cart_updated,
        'wishlist_updated' => $wishlist_updated
    ]);
})->name('sync-session-preferences');

Livewire::setScriptRoute(function ($handle) {
    return Route::get(url('/') . '/livewire/livewire.js', $handle);
});
