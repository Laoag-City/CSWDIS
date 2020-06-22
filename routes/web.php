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

	Route::get('client-search', 'ClientController@searchClients');

	Route::get('clients', 'ClientController@clientList')
			->name('client_list');

	Route::get('clients/{client}', 'ClientController@clientInfo');

	Route::match(['get', 'put'], 'clients/{client}/edit', 'ClientController@editClient');

	Route::delete('clients/{client}', 'ClientController@removeClient');

	Route::middleware(['admin'])->group(function(){
		//user and services/categories routes here

		Route::middleware(['confidential_view'])->group(function(){
			Route::match(['get', 'put'], 'records/{record}/edit', 'RecordController@editRecord');

			Route::delete('records/{record}', 'RecordController@removeRecord');
		});
	});

	Route::post('logout', 'AuthenticationController@logout')->name('logout');
});