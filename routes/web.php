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

Route::match(['get', 'post'], '/', 'AuthenticationController@login')//DONE
		->name('login')
		->middleware('guest');

Route::middleware(['auth'])->group(function () {
	Route::match(['get', 'post'], 'home', 'ClientController@addNewRecord')//DONE
			->name('home');

	Route::get('client-search', 'ClientController@searchClients')//DONE
			->name('search_client');

	Route::get('clients', 'ClientController@clientList')//DONE
			->name('client_list');

	Route::get('clients/{client}', 'ClientController@clientInfo')//DONE
			->name('client');

	Route::match(['get', 'put'], 'clients/{client}/edit', 'ClientController@editClient')//DONE
			->name('edit_client');

	Route::middleware(['confidential_view'])->group(function(){
		Route::match(['get', 'put'], 'records/{record}/edit', 'RecordController@editRecord')//DONE
				->name('edit_record');
	});

	Route::middleware(['admin'])->group(function(){
		Route::get('users-dashboard', 'AdminController@userDashboard')
					->name('users_dashboard');//DONE

		Route::post('user', 'AdminController@newUser')
					->name('new_user');//DONE

		Route::match(['get', 'put'], 'users/{user}', 'AdminController@editUser')
					->name('edit_user');//DONE

		Route::delete('users/{user}', 'AdminController@removeUser')
					->name('remove_user');//DONE

		Route::get('services-dashboard', 'AdminController@serviceDashboard')
					->name('services_dashboard');

		Route::post('service', 'AdminController@newService')
					->name('new_service');

		Route::match(['get', 'put'], 'services/{service}', 'AdminController@editService')
					->name('edit_service');

		Route::delete('services/{service}', 'AdminController@removeService')
					->name('remove_service');

		Route::delete('categories/{category}', 'AdminController@removeCategory');

		Route::delete('clients/{client}', 'ClientController@removeClient')//DONE
					->name('remove_client');

		Route::delete('records/{record}', 'RecordController@removeRecord')
					->name('remove_record');//DONE
	});

	Route::post('logout', 'AuthenticationController@logout')->name('logout');//DONE
});