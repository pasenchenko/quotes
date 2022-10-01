<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function PHPSTORM_META\map;

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

$localizationGroupAttributes = [
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
];

Route::group($localizationGroupAttributes, __DIR__ . '/web/fortify.php');

Route::group($localizationGroupAttributes, function () {
    Route::redirect('/', '/quotes')->name('index');

    Route::resource('quotes', QuoteController::class)->except('show');

    Route::middleware('can:admin')->name('admin.')->prefix('admin')->group(function () {
        Route::view('/', 'admin.index')->name('index');

        Route::resource('users', UserController::class)->only([
            'index', 'store', 'create', 'destroy'
        ]);
    });
});