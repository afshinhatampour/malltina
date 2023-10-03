<?php

use App\Http\Controllers\Api\V1\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Api\V1\Shop\ProductController as ShopProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'isAdmin']], function () {
    Route::apiResource('products', AdminProductController::class);
    Route::apiResource('orders', AdminOrderController::class)->except('store');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('products', ShopProductController::class)->only('index', 'show');
    Route::apiResource('orders', ShopOrderController::class);
});
