<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\app\Http\Controllers\ReviewController;
use Modules\Shop\app\Http\Controllers\ProductController;
use Modules\Shop\app\Http\Controllers\ProductUtilityController;
use Modules\Shop\app\Http\Controllers\ProductCategoryController;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation', 'shop']], function () {
    Route::resource('product/category', ProductCategoryController::class)->names('product.category')->except('show');
    Route::put('/product/category/status-update/{id}', [ProductCategoryController::class, 'statusUpdate'])->name('product.category.status-update');
    
    Route::resource('product', ProductController::class)->names('product')->except('show');
    Route::post('/product/file-store', [ProductController::class, 'upload'])->name('product.file-store');
    Route::delete('/product/file-remove/{file_name}', [ProductController::class, 'deleteUploadFile'])->name('product.file-remove');
    Route::get('/product/delete-used-files', [ProductController::class, 'deleteAllUnusedFiles'])->name('product.delete-used-files');
    Route::get('/product/file-download/{slug}', [ProductController::class, 'download'])->name('product.file-download');
    Route::put('/product/status-update/{id}', [ProductController::class, 'statusUpdate'])->name('product.status-update');

    Route::get('product-gallery/{id}',[ProductUtilityController::class, 'showGallery'])->name('product.gallery');
    Route::put('product-gallery/{id}', [ProductUtilityController::class, 'updateGallery'])->name('product.gallery.update');
    Route::delete('product-gallery/{id}',[ProductUtilityController::class, 'deleteGallery'])->name('product.gallery.delete');

    Route::resource('product-review', ReviewController::class)->names('product-review')->only(['index', 'show', 'destroy']);
    Route::put('/product-review/status-update/{id}', [ReviewController::class, 'statusUpdate'])->name('product-review.status-update');
});
