<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\HomePageController;

Route::group(['middleware' => ['maintenance.mode', 'translation']], function () {

    Route::controller(HomePageController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('change-theme/{name}', 'changeTheme')->name('change-theme');
        Route::view('contact','frontend.pages.contact')->name('contact');
        Route::get('team', 'team')->name('team');
        Route::get('team/{slug}', 'singleTeam')->name('single.team');
        Route::post('contact/member/{slug}', 'contactTeamMember')->name('contact.team.member')->middleware('throttle:4,60');
        Route::get('about', 'about')->name('about');
        Route::get('faq', 'faq')->name('faq');
        Route::get('pricing', 'pricing')->name('pricing');
        
        Route::get('portfolios', 'portfolios')->name('portfolios');
        Route::get('portfolios/{slug}', 'singlePortfolio')->name('single.portfolio');
        Route::get('services', 'services')->name('services');
        Route::get('services/{slug}', 'singleService')->name('single.service');
        
        Route::get('privacy-policy', 'privacyPolicy')->name('privacy-policy');
        Route::get('terms-condition', 'termsCondition')->name('terms-condition');
        Route::get('page/{slug}', 'customPage')->name('custom-page');
    });
    Route::controller(BlogController::class)->group(function () {
        Route::get('blogs', 'index')->name('blogs');
        Route::get('blogs/{slug}', 'show')->name('single.blog');
        Route::post('blogs/{slug}', 'blogCommentStore')->name('blog.comment.store')->middleware(['auth:web', 'verified']);
    });

    Route::middleware('shop')->group(function () {
        Route::view('shop', 'frontend.pages.shop.index')->name('shop');

        Route::controller(ShopController::class)->group(function(){
            Route::get('fetch-products', 'fetchProducts')->name('fetch.products');
            Route::get('shop/{slug}', 'singleProduct')->name('single.product');
        });
        Route::controller(CartController::class)->group(function(){
            Route::view('cart', 'frontend.pages.shop.cart')->name('cart');
            Route::get('add-to-cart/{slug}', 'addToCart')->name('add.cart');
            Route::post('update-cart/{rowId}', 'updateCart')->name('cart.update');
            Route::get('remove-from-cart/{rowId}', 'removeFromCart')->name('remove-from.cart');
            Route::post('apply-coupon', 'apply_coupon')->name('apply-coupon');
        });
    });
});
Route::get('set-language', [DashboardController::class, 'setLanguage'])->name('set-language');
Route::get('set-currency', [DashboardController::class, 'setCurrency'])->name('set-currency');

//maintenance mode route
Route::get('maintenance-mode', function () {
    $setting = cache()->get('setting', null);
    return $setting?->maintenance_mode ? view('global.maintenance') : redirect()->route('home');
})->name('maintenance.mode');

require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';

Route::fallback(function () {
    abort(404);
});