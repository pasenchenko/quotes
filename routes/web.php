<?php

use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Quote\QuoteController;
use App\Http\Controllers\Web\Quote\QuoteShareController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

    Route::get('quotes/{quote}/share/{channel}', [QuoteShareController::class, 'show'])
        ->whereIn('channel', array_keys(config('share.channels')))
        ->name('quotes.share.show');

    Route::post('quotes/{quote}/share/{channel}', [QuoteShareController::class, 'send'])
        ->whereIn('channel', array_keys(config('share.channels')))
        ->name('quotes.share.send');

    Route::middleware('can:admin')->name('admin.')->prefix('admin')->group(function () {
        Route::view('/', 'admin.index')->name('index');

        Route::resource('users', UserController::class)->only([
            'index', 'store', 'create', 'destroy'
        ]);
    });
});