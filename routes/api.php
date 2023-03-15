<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::apiResource('companies', App\Http\Controllers\CompanyController::class);
        Route::apiResource('employees', App\Http\Controllers\CompanyEmployeeController::class)->only(['index', 'show']);
    });

    Route::group(['middleware' => ['role:company|admin']], function () {
        Route::apiResource('companies', App\Http\Controllers\CompanyController::class)->only(['update', 'show', 'destroy']);
        Route::apiResource('employees', App\Http\Controllers\CompanyEmployeeController::class);
    });

    Route::apiResource('profiles', App\Http\Controllers\ProfileController::class)->except('store');
});

Route::middleware('guest')->group(function () {
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
});
