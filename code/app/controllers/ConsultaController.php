<?php

use Illuminate\Support\Facades\View;

/**
 * Class ConsultaController
 */
class ConsultaController extends ApiController
{
	/**
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return mixed
	 */
	public function historica()
	{
		return View::make('dashboard.consultas.historica');
	}

	/**
	 * @return mixed
	 */
	public function individual()
	{
		return View::make('dashboard.consultas.individual');
	}
} 
