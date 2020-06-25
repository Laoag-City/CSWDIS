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

	Route::get('client-search', 'ClientController@searchClients')
			->name('search_client');

	Route::get('clients', 'ClientController@clientList')
			->name('client_list');

	Route::get('clients/{client}', 'ClientController@clientInfo')
			->name('client');

	Route::match(['get', 'put'], 'clients/{client}/edit', 'ClientController@editClient');

	Route::middleware(['confidential_view'])->group(function(){
		Route::match(['get', 'put'], 'records/{record}/edit', 'RecordController@editRecord');
	});

	Route::middleware(['admin'])->group(function(){
		Route::get('users-dashboard', 'AdminController@userDashboard');

		Route::post('user', 'AdminController@newUser');

		Route::match(['get', 'put'], 'users/{user}', 'AdminController@editUser');

		Route::delete('users/{user}', 'AdminController@removeUser');

		Route::get('services-dashboard', 'AdminController@serviceDashboard');

		Route::post('service', 'AdminController@newService');

		Route::match(['get', 'put'], 'services/{service}', 'AdminController@editService');

		Route::delete('services/{service}', 'AdminController@removeService');

		Route::delete('categories/{category}', 'AdminController@removeCategory');

		Route::delete('clients/{client}', 'ClientController@removeClient');

		Route::delete('records/{record}', 'RecordController@removeRecord');
	});

	Route::post('logout', 'AuthenticationController@logout')->name('logout');
});