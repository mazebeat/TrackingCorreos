<?php

use App\Util\Functions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
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
		$url        = Input::get('url', 'http://192.168.1.99:9800/GestionMailWS/Despacho/ConsultaDespacho');
		$fecha      = new Carbon(Input::get('fecha'));
		$fechaDesde = $fecha->firstOfMonth()->format('Ymd');
		$fechaHasta = $fecha->lastOfMonth()->format('Ymd');
		$idcampana  = \Input::get('idCampana', '');
		$params     = array('fechaDesde' => $fechaDesde, 'fechaHasta' => $fechaHasta, 'idcampana' => (int)$idcampana);
		$result     = App\Util\Functions::curlRequest($url, $params, 'POST');

		if ($result->ok) {
			$data = json_decode('[' . substr($result->data, 0, (int)strlen($result->data) - 1) . ']');
			$structure = array('NCampana' => 'Campaña', 'NNegocio' => 'Negocio', 'fechaDespacho' => 'Fecha Despacho', 'fechaRetencion' => 'Fecha Retención', 'mail' => 'Email');
//			$this->printExcel(\HTML::tableize($structure, $data, true), \Str::upper(Input::get('campana', 'DETALLE')));
			return json_encode(array('ok' => true, 'data' => \HTML::tableize($structure, $data, true)));
//			$this->downloadDetail($data, \Str::upper(Input::get('campana', 'DETALLE')));
//			Response::download($pathToFile, $name, $headers);
		}
		else {
			return json_encode(array('ok' => false, 'error' => 'error fatal'));
		}
	}
}