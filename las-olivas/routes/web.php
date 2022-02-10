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
    Route::post('/clients-search', 'App\Http\Controllers\ClientController@client_search')->name('clients-search');
    Route::get('/clients-add', 'App\Http\Controllers\ClientController@index_add_client')->name('clients-add');
    Route::post('/clients-add', 'App\Http\Controllers\ClientController@add_client')->name('clients-add');
    Route::post('/clients-update', 'App\Http\Controllers\ClientController@update_client')->name('clients-update');
    Route::post('/clients-delete', 'App\Http\Controllers\ClientController@delete_client')->name('delete-client');
    Route::post('/clients-data-for-update', 'App\Http\Controllers\ClientController@update_client_index')->name('clients-data-for-update');
});

// Movements routes
Route::group(['middleware' => 'auth'] , function () {
    Route::get('/movements-dashboard', 'App\Http\Controllers\MovementController@index')->name('movements-dashboard');
    Route::post('/movements-by-client', 'App\Http\Controllers\MovementController@list_client_movements')->name('movements-client-list');
    Route::post('/movements-add', 'App\Http\Controllers\MovementController@add_movement')->name('movements-add');
});

// PDF routes
Route::group(['middleware' => 'auth'] , function () {
    Route::post('/download-client-movements', 'App\Http\Controllers\PDFController@download_pdf')->name('download-client-movements');
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

// Labels routes: categories, brands and sizes.
Route::group(['middleware' => 'auth'], function () {
    Route::get('/labels', 'App\Http\Controllers\CategoryController@index')->name('labels-index');
    Route::post('/labels-add-category', 'App\Http\Controllers\CategoryController@add')->name('labels-add-category');
    Route::post('/labels-add-brand', 'App\Http\Controllers\BrandController@add')->name('labels-add-brand');
    Route::post('/labels-add-size', 'App\Http\Controllers\SizeController@add')->name('labels-add-size');
});

require __DIR__.'/auth.php';
