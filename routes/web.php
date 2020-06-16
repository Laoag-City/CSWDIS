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
	Route::get('home', 'HomeController')
			->name('home');

	Route::post('logout', 'AuthenticationController@logout')->name('logout');
});
