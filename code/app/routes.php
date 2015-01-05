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
    Route::group(array('prefix' => 'dashboard'), function () {
        Route::get('/', 'DashboardController@index');
        Route::group(array('prefix' => 'consultas'), function () {
            Route::get('historica', 'ConsultaController@historica');
            Route::get('individual', 'ConsultaController@individual');
            Route::get('visualizar', 'ConsultaController@visualizar');
        });
        Route::group(array('prefix' => 'reportes'), function () {
            Route::get('lecturatot', 'ReporteController@lecturatot');
        });
        Route::get('tracking', 'TrackingController@index');
        Route::group(array('prefix' => 'administracion'), function () {
            //		User resource
            Route::resource('usuarios', 'UsersController');
        });
//
        Route::get('authUser', 'DashboardController@authUser');
        Route::get('getSearchTracking', 'TrackingController@getSearchTracking');
        Route::post('setSearchTracking', 'TrackingController@setSearchTracking');
    });
});

Route::post('processData', function () {
    $data = Input::except('_token');
    $arreglo = array();
    $config = array();
    $camapañas = array();
    $count = 0;
    foreach ((object)$data as $value) {
        $fecha = array_get($value, 'ano') . '-' . array_get($value, 'mes');
        array_push($camapañas, array_get($value, 'campana.nombre'));
        if (isset($arreglo[$fecha])) {
            $arreglo[$fecha] = array_add($arreglo[$fecha], array_get($value, 'campana.nombre'), array_get($value, 'qelectronicos'));
        } else {
            $arreglo[$fecha] = array('fecha' => $fecha, array_get($value, 'campana.nombre') => array_get($value, 'qelectronicos'));
        }
    }

    foreach ($arreglo as $value) {
        $config['data'][] = $value;
    }
    $config['graphs'] = array_unique($camapañas);
    return Response::json($config);
});


