<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(array('after' => 'auth'), function () {
	Route::get('/', 'HomeController@index');
	Route::post('login', 'HomeController@login');
});

Route::group(array('before' => 'auth'), function () {
	Route::get('logout', 'HomeController@logout');
	Route::get('dashboard', 'DashboardController@index');
});
