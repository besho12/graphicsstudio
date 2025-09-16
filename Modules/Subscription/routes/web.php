<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscription\app\Http\Controllers\Admin\SubscriptionPlanController;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation']], function () {
    Route::resource('pricing-plan', SubscriptionPlanController::class)->names('pricing-plan');
});