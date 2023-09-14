<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\User\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // auth
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::middleware('auth')->namespace('App\Http\Controllers\Api\V1')->group(function () {
        // user
        Route::prefix('user')->namespace('User')->group(function () {
            Route::get('product', [ProductController::class, 'index']);
            Route::apiResource('shopping-cart', 'ShoppingCartController');
        });

        // admin
        Route::prefix('admin')
            ->namespace('Admin')
            ->middleware('IsAdmin')
            ->group(function () {
                Route::apiResource('product', 'ProductController');
                Route::apiResource('category', 'CategoryController')
                    ->only(['index', 'store', 'destroy']);
                Route::apiResource('sub-category', 'SubCategoryController')
                    ->only(['store', 'destroy']);
            });
    });

});
