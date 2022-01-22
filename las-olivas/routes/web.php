<?php

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

Route::get('/', function () {
    return view('/auth/login');
});

// Clients routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/clients-dashboard', 'App\Http\Controllers\ClientController@index')->name('clients-dashboard');
    Route::get('/clients-search', 'App\Http\Controllers\ClientController@client_search')->name('clients-search');
    Route::get('/clients-add', 'App\Http\Controllers\ClientController@index_add_client')->name('clients-add');
    Route::post('/clients-add', 'App\Http\Controllers\ClientController@add_client')->name('clients-add');
    Route::post('/clients-update', 'App\Http\Controllers\ClientController@update_client')->name('clients-update');
    Route::get('/clients-update', 'App\Http\Controllers\ClientController@client_modification')->name('clients-update');
});

// Movements routes
Route::group(['middleware' => 'auth'] , function () {
    Route::get('/filter-or-download', 'App\Http\Controllers\MovementController@decider')->name('filter-or-download');
    Route::get('/movements-dashboard', 'App\Http\Controllers\MovementController@index')->name('movements-dashboard');
    Route::get('/movements-by-client', 'App\Http\Controllers\MovementController@list_client_movements')->name('movements-client-list');
    Route::post('/movements-add', 'App\Http\Controllers\MovementController@add_movement')->name('movements-add');
});

// PDF routes
Route::group(['middleware' => 'auth'] , function () {
    Route::get('/download-client-movements', 'App\Http\Controllers\PDFController@download_pdf')->name('download-client-movements');
});

// Sales routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/add-previous-monthly-sale', 'App\Http\Controllers\MonthlySalesController@index')->name('monthly-sales-index');
    Route::post('/monthly-sales-add', 'App\Http\Controllers\MonthlySalesController@add_monthly_sale')->name('monthly-sales-add');
});

// Statistics and charts routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'App\Http\Controllers\StatisticsController@index')->name('dashboard');
});

require __DIR__.'/auth.php';
