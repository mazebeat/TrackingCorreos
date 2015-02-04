<?php
//Memory
ini_set('memory_limit', '3500M');
ini_set('max_execution_time', '0');
ini_set('set_time_limit', '0');
//Iconv
iconv_set_encoding('internal_encoding', 'UTF-8');
iconv_set_encoding('input_encoding', 'UTF-8');
iconv_set_encoding('output_encoding', 'UTF-8');
//XDebug
ini_set('xdebug.collect_vars', 'on');
ini_set('xdebug.collect_params', '4');
ini_set('xdebug.dump_globals', 'on');
ini_set('xdebug.dump.SERVER', 'REQUEST_URI');
//Errors
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);


/**
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the Closure to execute when that URI is requested.
 * |
 */

Route::group(array('after' => 'auth'), function () {
	Route::get('/', 'HomeController@index');
	Route::post('login', 'HomeController@login');
});

Route::group(array('before' => 'auth'), function () {
	Route::get('logout', 'HomeController@logout');
	Route::group(array('prefix' => 'dashboard'), function () {
		Route::get('/', 'DashboardController@index');
		Route::group(array('prefix' => 'consultas', 'before' => 'admin'), function () {
			Route::get('historica', 'ConsultaController@historica');
			Route::get('individual', 'ConsultaController@individual');
			Route::get('visualizar', 'ConsultaController@visualizar');
		});
		Route::group(array('prefix' => 'reportes', 'before' => 'admin'), function () {
			Route::get('lecturatot', 'ReporteController@lecturatot');
		});
		Route::get('tracking', 'TrackingController@index');
		Route::group(array('prefix' => 'administracion', 'before' => 'admin'), function () {
			Route::resource('usuarios', 'UsersController');
		});
		//
		Route::get('authUser', 'DashboardController@authUser');
		Route::get('getSearchTracking', 'TrackingController@getSearchTracking');
		Route::post('setSearchTracking', 'TrackingController@setSearchTracking');
		Route::get('excel', 'TrackingController@downloadCSVDetail');
	});
});

Route::post('processData', function () {
	$data      = Input::except('_token');
	$arreglo   = array();
	$config    = array();
	$camapañas = array();
	foreach ((object)$data as $value) {
		$fecha = array_get($value, 'ano') . '-' . array_get($value, 'mes');
		array_push($camapañas, array_get($value, 'campana.nombre'));
		if (isset($arreglo[$fecha])) {
			$arreglo[$fecha] = array_add($arreglo[$fecha], array_get($value, 'campana.nombre'), array_get($value, 'qelectronicos'));
		}
		else {
			$arreglo[$fecha] = array('fecha' => $fecha, array_get($value, 'campana.nombre') => array_get($value, 'qelectronicos'));
		}
	}

	foreach ($arreglo as $value) {
		$config['data'][] = $value;
	}
	$config['graphs'] = array_unique($camapañas);

	return Response::json($config);
});

Route::get('curl', function () {
	header('Content-type: application/vnd.ms-excel');
	header('Content-disposition: attachment; filename="test.csv"');
	$f = fopen('php://output', 'w');
	fwrite($f,'this,is,a,test');
	fclose($f);
	readfile('php://output');
	return;
});