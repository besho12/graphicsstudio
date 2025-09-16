<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\app\Http\Controllers\OrderController;
use Modules\Order\app\Http\Controllers\ShippingMethodController;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation','shop']], function () {

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders');
        Route::put('/orders/status-update/{id}', 'statusUpdate')->name('order.status-update');
        Route::get('/pending-orders', 'pending_order')->name('pending-orders');
        Route::get('/order/{id}', 'show')->name('order');
        Route::post('/order-payment-reject/{id}', 'order_payment_reject')->name('order-payment-reject');
        Route::post('/order-payment-approved/{id}', 'order_payment_approved')->name('order-payment-approved');
        Route::delete('/order-delete/{id}', 'destroy')->name('order-delete');
        Route::get('/pending-payment', 'pending_payment')->name('pending-payment');
        Route::get('/rejected-payment', 'rejected_payment')->name('rejected-payment');
    });

    Route::get('shipping-method', [ShippingMethodController::class,'index'])->name('shipping-method.index');
    Route::post('shipping-method', [ShippingMethodController::class,'store'])->name('shipping-method.store');
    Route::post('shipping-method/{id}', [ShippingMethodController::class,'update'])->name('shipping-method.update');
    Route::delete('shipping-method/{id}', [ShippingMethodController::class,'destroy'])->name('shipping-method.destroy');
    Route::put('/shipping-method/status-update/{id}', [ShippingMethodController::class, 'statusUpdate'])->name('shipping-method.status-update');
});
