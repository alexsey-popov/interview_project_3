<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\PriceListItemController;

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

Route::controller(PriceListController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/price-list/{id}', 'show')->whereNumber('id')->name('price-list-show');
    Route::get('/price-list/{id}/edit', 'edit')->whereNumber('id')->name('price-list-edit');
    Route::post('/price-list/{id}/edit', 'update')->whereNumber('id');
    Route::get('/price-list/{id}/delete', 'destroy')->whereNumber('id');

    Route::get('/export', 'export')->name('export');
    Route::get('/download', 'download')->name('download');
});

Route::controller(PriceListItemController::class)->group(function () {
    Route::get('/price-list/{list}/{item}/edit', 'edit')->whereNumber('list', 'item')->name('price-list-item-edit');
    Route::post('/price-list/{list}/{item}/edit', 'update')->whereNumber('list', 'item');
    Route::get('/price-list/{list}/{item}/delete', 'destroy')->whereNumber('list', 'item');
});
