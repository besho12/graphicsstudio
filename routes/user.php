<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\User\RefundController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\CheckoutController;
use App\Http\Controllers\Frontend\User\WishListController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\BillingAddressController;
use App\Http\Controllers\Frontend\User\CustomerReviewController;

Route::get('/dashboard', fn() => to_route('user.dashboard'))->name('dashboard');

Route::middleware(['auth:web', 'verified', 'translation', 'maintenance.mode'])->name('user.')->prefix('user')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('update-password', [ProfileController::class, 'change_password'])->name('change-password');
    Route::post('update-password', [ProfileController::class, 'update_password'])->name('update-password');
    Route::post('update-profile-image', [ProfileController::class, 'update_image'])->name('update.profile-image');

    Route::middleware('shop')->group(function () {
        Route::controller(WishListController::class)->group(function () {
            Route::view('wishlist', 'frontend.profile.wishlist')->name('wishlist.index');
            Route::get('wishlist/{product:slug}', 'update')->name('wishlist.update');
            Route::delete('wishlist/{product:slug}', 'destroy')->name('wishlist.remove');
        });
        Route::resource('customers-review', CustomerReviewController::class)->names('customers-review')->only(['index', 'store']);

        Route::controller(CheckoutController::class)->group(function () {
            Route::get('checkout', 'index')->name('checkout');
            Route::post('shipping-method/update/{id}', 'updateShippingMethod')->name('update.shipping-method');
            Route::post('store-billing-address', 'storeBillingAddress')->name('store.billing');
            Route::get('buy-now/{slug}', 'buyNow')->name('buy.now');
            Route::post('buy-now-shipping-method/update/{id}/{slug}', 'updateBuyNowShippingMethod')->name('update.buy.now.shipping-method');
        });

        Route::controller(DashboardController::class)->group(function () {
            Route::get('order', 'order')->name('order');
            Route::get('order/{order_id}', 'order_show')->name('order.show');
            Route::get('invoice/{order_id}', 'invoice')->name('invoice');
            Route::get('digital/products', 'digitalProducts')->name('digital.products');
            Route::get('digital/products/{slug}/download', 'download')->name('digital.product-download');
        });
        Route::controller(BillingAddressController::class)->name('billing.')->prefix('billing')->group(function () {
            Route::get('address', 'index')->name('index');
            Route::post('address', 'store')->name('store');
            Route::patch('address/{id}', 'update')->name('update');
            Route::delete('address/{id}', 'destroy')->name('destroy');
        });
        Route::post('refund-request/{order:order_id}', [RefundController::class, 'store'])->name('refund-request');

    });
    Route::get('pricing-plan', [DashboardController::class, 'pricing'])->name('pricing');
});