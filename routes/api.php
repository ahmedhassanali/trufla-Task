<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\productController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('users',[UserController::class, 'store']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::apiResource('users', UserController::class)->except('store');
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('products',[productController::class,'index']);
    Route::get('products/{product}',[productController::class,'show']);
    Route::apiResource('products', productController::class)->middleware('userRole:seller')->except('show','index');

    Route::apiResource('orders', OrderController::class)->middleware('userRole:buyer');

});
