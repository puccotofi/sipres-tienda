<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::post('/sync/cart-wishlist', [CartController::class, 'syncCartWishlist'])
        ->name('sync.cart.wishlist')
        ->middleware('auth');

    Route::delete('/cart/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/wishlist/{product_id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    Route::post('/shipping-address', [ShippingAddressController::class, 'store'])->name('shipping.store');

    Route::post('/checkout/stripe', [PaymentController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/checkout/success', [PaymentController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel');

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::post('/dashboard/address', [ShippingAddressController::class, 'storeAddress'])->name('address.store');
    Route::put('/dashboard/address/{id}', [ShippingAddressController::class, 'updateAddress'])->name('address.update');
    Route::delete('/dashboard/address/{id}', [ShippingAddressController::class, 'destroyAddress'])->name('address.destroy');

    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/{id}/{slug}', [ProductController::class, 'details'])->name('product.details');

Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

Route::get('/shop', [ProductController::class, 'shop'])->name('shop.index');

require __DIR__.'/auth.php';
