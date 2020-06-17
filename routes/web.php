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

Route::match(['get', 'post'], '/', 'AuthenticationController@login')
		->name('login')
		->middleware('guest');

Route::middleware(['auth'])->group(function () {
	Route::match(['get', 'post'], 'home', 'ClientController@addNewRecord')
			->name('home');

	Route::get('clients', 'ClientController@clientList');

	Route::get('clients/{client}', 'ClientController@clientInfo');

	Route::match(['get', 'put'], 'clients/{client}/edit', 'ClientController@editClient');

	Route::match(['get', 'put'], 'records/{record}/edit', 'RecordController@editRecord');

	Route::delete('clients/{client}', 'ClientController@removeClient');

	Route::delete('records/{record}', 'RecordController@removeRecord');

	Route::post('logout', 'AuthenticationController@logout')->name('logout');
});