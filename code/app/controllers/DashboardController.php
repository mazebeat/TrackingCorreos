<?php

use Illuminate\Support\Facades\View;

/**
 * Class DashboardController
 */
class DashboardController extends ApiController
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
	public function index()
	{
		return View::make('dashboard.index');
	}
} 
