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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Clients routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/clients-dashboard', 'App\Http\Controllers\ClientController@index')->name('clients-dashboard');
    Route::get('/clients-modification', 'App\Http\Controllers\ClientController@client_modification')->name('clients-update');
    Route::get('/clients-search', 'App\Http\Controllers\ClientController@client_search')->name('clients-search');
    Route::get('/clients-add', 'App\Http\Controllers\ClientController@index_add_client')->name('clients-add');
    Route::post('/clients-add', 'App\Http\Controllers\ClientController@add_client')->name('clients-add');
});

require __DIR__.'/auth.php';
