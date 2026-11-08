<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;


Route::group(['prefix' => 'user'], function () {

    Route::get('home', [UserController::class, 'index'])->name('home');
    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::get('product/details/{id}', [UserController::class, 'productDetails'])->name('user#productDetails');
    Route::get('newarrivals', [UserController::class, 'newArrivals'])->name('newarrivals');
    Route::get('special-offers', [UserController::class, 'specialOffers'])->name('specialOffers');
    Route::get('most-popular', [UserController::class, 'mostPopular'])->name('mostPopular');

    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

    Route::group(['middleware' => 'userMiddleware'], function () {

        // Reviews
        Route::post('review', [UserController::class, 'review'])->name('user#review');
        Route::delete('review/{id}', [UserController::class, 'deleteReview'])->name('user#reviewDelete');

        // Cart
        Route::get('cart', [UserController::class, 'cart'])->name('user#cart');
        Route::post('cart/add', [UserController::class, 'addToCart'])->name('user#addToCart');
        Route::post('cart/update', [UserController::class, 'updateCartQuantity'])->name('user#cartUpdate');
        Route::post('cart/remove', [UserController::class, 'removeCartItem'])->name('user#cartRemove');
        Route::post('cart/apply-discount', [UserController::class, 'applyDiscount'])->name('user#applyDiscount');

        // Checkout & Payment
        Route::post('order/place', [UserController::class, 'placeOrder'])->name('user#placeOrder');
        Route::get('payment', [UserController::class, 'paymentPage'])->name('user#paymentPage');
        Route::post('payment/submit', [UserController::class, 'submitPayment'])->name('user#submitPayment');

        // Order History
        Route::get('orders', [UserController::class, 'orders'])->name('user#orders');
        Route::get('orders/{order}', [UserController::class, 'orderDetails'])->name('user#orderDetails');

        // Wishlist
        Route::get('wishlist', [UserController::class, 'wishlist'])->name('user#wishlist');
        Route::post('wishlist/add', [UserController::class, 'addToWishlist'])->name('user#wishlistAdd');
        Route::post('wishlist/remove', [UserController::class, 'removeFromWishlist'])->name('user#wishlistRemove');

        // Alerts & Notifications
        Route::post('alerts/register/{product}', [UserController::class, 'registerRestockAlert'])->name('user#registerRestockAlert');
        Route::post('alerts/unregister/{product}', [UserController::class, 'unregisterRestockAlert'])->name('user#unregisterRestockAlert');
        Route::get('alerts', [UserController::class, 'alerts'])->name('user#alerts');
        Route::post('alerts/mark-read/{alert}', [UserController::class, 'markAlertRead'])->name('user#alertMarkRead');
        Route::post('alerts/mark-all-read', [UserController::class, 'markAllAlertsRead'])->name('user#alertMarkAllRead');

        // Profile Management
        Route::group(['prefix' => 'profile'], function () {
            Route::get('change/password', [ProfileController::class, 'userchangePasswordPage'])->name('userprofile#changePasswordPage');
            Route::post('change/password', [ProfileController::class, 'userchangePassword'])->name('userprofile#changePassword');
            Route::get('edit', [ProfileController::class, 'usereditProfile'])->name('userprofile#edit');
            Route::post('update', [ProfileController::class, 'userupdateProfile'])->name('userprofile#update');
        });
    });
});
