<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'quotes.index')->name('index');

Route::name('quotes.')->group(function () {
    // Route::view('/', 'quotes.index')->name('index');

    Route::middleware('auth')->group(function () {
    });
});

Route::middleware('can:admin')->name('admin.')->prefix('admin')->group(function () {
    Route::view('/', 'admin.index')->name('index');

    Route::resource('users', UserController::class)->only([
        'index', 'store', 'create', 'destroy'
    ]);
});