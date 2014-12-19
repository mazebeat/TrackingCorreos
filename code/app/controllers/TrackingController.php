<?php

use Illuminate\Support\Facades\View;

/**
 * Class TrackingController
 */
class TrackingController extends ApiController
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
		return View::make('dashboard.tracking.index');
	}
} 
