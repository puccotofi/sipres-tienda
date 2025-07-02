<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;

use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\DasboardController;

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

    // Rutas de administrador
    
    //Route::resource('categories', CategoryController::class);
    //Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    
    Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('admindashboard', [DasboardController::class, 'index'])->name('admindashboard');
    
    Route::get('categories/{category}/products', [CategoryController::class, 'products'])->name('category.products');
    Route::resource('categories', CategoryController::class);    
    Route::get('brands/{brand}/products', [BrandController::class, 'products'])->name('brands.products');

    // Otras rutas del recurso brands
    Route::resource('brands', BrandController::class);
    
    //Route::get('brand/{id}', [BrandController::class, 'show_products'])->name('brands.products');
    Route::resource('products', ProductController::class);
    Route::get('suppliers/{supplier}/products', [SupplierController::class, 'products'])->name('suppliers.products');
    Route::resource('suppliers', SupplierController::class);
    Route::get('orders/{order}',[OrderController::class, 'show'])->name('admin.orders.show');
    Route::get('orders/{order}/addresses', [OrderController::class, 'editShippingAddress'])->name('orders.addresses');
    Route::put('orders/{order}/addresses/{address}', [OrderController::class, 'updateShippingAddress'])->name('orders.updateShipping');
    Route::post('orders/{order}/addresses', [OrderController::class, 'storeShippingAddress'])->name('orders.addresses.store');
    Route::put('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('orders/{order}/add-note', [OrderController::class, 'addNote'])->name('orders.addNote');
    Route::get('orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::get('orders/status/{status}', [OrderController::class, 'indexByStatus'])->name('orders.status');

    //Route::get('orders/{order}/updateaddress',[OrderController::class, 'updateAddress'])->name('admin.orders.updateAddress');
    Route::post('orders/{order}/addproduct', [OrderController::class, 'addProduct'])->name('orders.addProduct');
    Route::delete('orders/{order}/items/{orderItem}', [OrderController::class, 'removeProduct'])->name('orders.removeProduct');
    Route::resource('orders', OrderController::class);
    
});
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop.index');
Route::get('product/{id}/{slug}', [ProductController::class, 'details'])->name('product.details');
Route::get('category/{id}', [CategoryController::class, 'show'])->name('categories.products');


require __DIR__.'/auth.php';
 