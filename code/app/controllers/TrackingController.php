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

	/**
	 * @return mixed
	 */
	public function getSearchTracking()
	{
		return Session::get('searchTracking', array());
	}

	/**
	 *
	 */
	public function setSearchTracking()
	{
		if (Session::has('searchTracking')) {
			Session::forget('searchTracking');
		}

		Session::put('searchTracking', Input::all());
	}

	/**
	 *
	 */
	public function downloadCSVDetail()
	{
		$url    = 'https://api.twitter.com/1.1/help/configuration.json';
		$params = array('idcampana' => Input::get('idcampana', ''), 'fechaDesde' => Input::get('fechaDesde', ''), 'fechaHasta' => Input::get('fechaHasta', ''));
		$result = App\Util\Functions::curlRequest($url, $params, 'POST', true);
		dd($result);
		$this->downloadDetail(Functions::objectToArray($result->data), \Str::upper(Input::get('campana', 'DETALLE')));
	}
} 
