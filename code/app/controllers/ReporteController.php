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
//	public function fisico()
//	{
//		return View::make('dashboard.reportes.fisico');
//	}
//
//	/**
//	 * @return mixed
//	 */
//	public function electronico()
//	{
//		return View::make('dashboard.reportes.electronico');
//	}
	public function lecturatot()
	{
		return View::make('dashboard.reportes.lecturatot');
	}
} 
