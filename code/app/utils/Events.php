<?php namespace App\Util;

use Carbon\Carbon;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class CustomEvents
 *
 * @package App\Util
 */
class CustomEvents
{
	/**
	 * @var \Monolog\Logger
	 */
	private $monolog;
	/**
	 * @var
	 */
	private $logFile;
	/**
	 * @var
	 */
	private $logMsg;
	/**
	 * @var
	 */
	private $info_server;
	/**
	 * @var static
	 */
	private $now;

	/**
	 *
	 */
	public function __construct()
	{
		$this->monolog     = new Logger('log');
		$this->info_server = \App\Util\Functions::serverData();
		$this->now         = Carbon::now();
	}

	/**
	 * @param $user
	 */
	public function login($user)
	{
		$this->logFile = storage_path() . '/logs/users.log';
		$this->logMsg  = 'LOGIN OK | USER-ID ' . $user->id . ' | IP-ADDRESS ' . array_get($this->info_server, 'IP') . ' | BROWSER ' . array_get($this->info_server, 'BROWSER') . PHP_EOL;
		$this->monolog->pushHandler(new StreamHandler($this->logFile), Logger::INFO);
		$this->monolog->info($this->logMsg, compact('bindings', 'time'));
	}

	/**
	 * @param $user
	 */
	public function loginFailed($user)
	{
		$this->logFile = storage_path() . '/logs/users.log';
		$this->logMsg  = 'LOGIN FAILED | USER-ID ' . $user->id . ' | IP-ADDRESS ' . array_get($this->info_server, 'IP') . ' | BROWSER ' . array_get($this->info_server, 'BROWSER') . PHP_EOL;
		$this->monolog->pushHandler(new StreamHandler($this->logFile), Logger::WARNING);
		$this->monolog->info($this->logMsg, compact('bindings', 'time'));
	}

	/**
	 * @param $user
	 */
	public function logout($user)
	{
		$this->logFile = storage_path() . '/logs/users.log';
		$this->logMsg  = 'LOGOUT | USER-ID ' . $user->id . ' | IP-ADDRESS ' . array_get($this->info_server, 'IP') . ' | BROWSER ' . array_get($this->info_server, 'BROWSER') . PHP_EOL;
		$this->monolog->pushHandler(new StreamHandler($this->logFile), Logger::INFO);
		$this->monolog->info($this->logMsg, compact('bindings', 'time'));
	}

	/**
	 * @param $sql
	 * @param $bindings
	 * @param $time
	 */
	public function database($sql, $bindings, $time)
	{
		$this->logFile = storage_path() . '/logs/database.log';
		$sql           = str_replace(array('%', '?'), array('%%', '%s'), $sql);
		$sql           = vsprintf($sql, $bindings);
		$this->logMsg  = 'DATE ' . Carbon::now() . ' | QUERY ' . $sql . ' | TIME ' . $time . 'ms' . PHP_EOL;
		$this->monolog->pushHandler(new StreamHandler($this->logFile), Logger::INFO);
		$this->monolog->info($this->logMsg, compact('bindings', 'time'));
	}
}

\Event::listen('auth.login', '\App\Util\CustomEvents@login');
\Event::listen('user.login.failed', '\App\Util\CustomEvents@loginFailed');
\Event::listen('auth.logout', '\App\Util\CustomEvents@logout');
if (\Config::get('database.debug', false)) {
	\Event::listen('illuminate.query', '\App\Util\CustomEvents@database');
}
