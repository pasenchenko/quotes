<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Quote\QuoteController;
use App\Http\Controllers\Api\V1\Quote\QuoteShareController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::apiResource('quotes', QuoteController::class)->except('show');

Route::post('quotes/{quote}/share/{channel}', [QuoteShareController::class, 'send'])
    ->whereIn('channel', array_keys(config('share.channels')))
    ->name('quotes.share.send');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('can:admin')->name('admin.')->prefix('admin')->group(function () {
        Route::apiResource('users', UserController::class)->only([
            'index', 'store', 'destroy'
        ]);
    });
});