<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Filename & Format
	|--------------------------------------------------------------------------
	|
	| The default filename (without extension) and the format (php or json)
	|
	*/

	'filename'        => '_ide_helper',
	'format'          => 'json',
	/*
	|--------------------------------------------------------------------------
	| Helper files to include
	|--------------------------------------------------------------------------
	|
	| Include helper files. By default not included, but can be toggled with the
	| -- helpers (-H) option. Extra helper files can be included.
	|
	*/

	'include_helpers' => true,
	'helper_files'    => array(base_path() . '/vendor/laravel/framework/src/Illuminate/Support/helpers.php',),
	/*
	|--------------------------------------------------------------------------
	| Model locations to include
	|--------------------------------------------------------------------------
	|
	| Define in which directories the ide-helper:models command should look
	| for models.
	|
	*/

	'model_locations' => array('app/models',),
	/*
	|--------------------------------------------------------------------------
	| Extra classes
	|--------------------------------------------------------------------------
	|
	| These implementations are not really extended, but called with magic functions
	|
	*/

	'extra'           => array('Artisan'  => array('Illuminate\Foundation\Artisan'),
	                           'Eloquent' => array('Illuminate\Database\Eloquent\Builder',
		                           'Illuminate\Database\Query\Builder'),
	                           'Session'  => array('Illuminate\Session\Store'),),
	'magic'           => array('Log' => array('debug'     => 'Monolog\Logger::addDebug',
	                                          'info'      => 'Monolog\Logger::addInfo',
	                                          'notice'    => 'Monolog\Logger::addNotice',
	                                          'warning'   => 'Monolog\Logger::addWarning',
	                                          'error'     => 'Monolog\Logger::addError',
	                                          'critical'  => 'Monolog\Logger::addCritical',
	                                          'alert'     => 'Monolog\Logger::addAlert',
	                                          'emergency' => 'Monolog\Logger::addEmergency',)),
	/*
	|--------------------------------------------------------------------------
	| Interface implementations
	|--------------------------------------------------------------------------
	|
	| These interfaces will be replaced with the implementing class. Some interfaces
	| are detected by the helpers, others can be listed below.
	|
	*/

	'interfaces'      => array('\Illuminate\Auth\UserInterface' => '\User',)

);
