<?php

use Illuminate\Support\Facades\View;

/**
 * Class ReporteController
 */
class ReporteController extends ApiController
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
	public function lecturatot()
	{
		return View::make('dashboard.reportes.lecturatot');
	}
} 
