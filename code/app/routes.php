<?php
//var_dump(Auth::user());
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
	Route::group(array('prefix' => 'dashboard'), function () {
		Route::get('/', 'DashboardController@index');
		Route::get('authUser', 'DashboardController@authUser');
		Route::group(array('prefix' => 'consultas'), function () {
			Route::get('historica', 'ConsultaController@historica');
			Route::get('individual', 'ConsultaController@individual');
		});
		Route::group(array('prefix' => 'reportes'), function () {
			Route::get('electronico', 'ReporteController@electronico');
			Route::get('fisico', 'ReporteController@fisico');
		});
		Route::get('tracking', 'TrackingController@index');
		Route::group(array('prefix' => 'administracion'), function () {
		});
	});
});


