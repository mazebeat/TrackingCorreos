<?php

use Illuminate\Support\Facades\Crypt;

/**
 * Class ApiController
 */
class ApiController extends BaseController
{
	/**
	 * @var null
	 */
	private $token;
	/**
	 * @var array
	 */
	private $data;
	/**
	 * @var int
	 */
	private $status;
	/**
	 * @var array
	 */
	private $headers;

	/**
	 * @param null  $token
	 * @param array $data
	 * @param int   $status
	 * @param array $headers
	 */
	public function __construct($token = null, $data = array(), $status = 200, $headers
	= array('ContentType' => 'application/json', 'charset' => 'utf-8'))
	{
		$this->token   = isset($token) ? $token : Crypt::encrypt(str_random(40));
		$this->data    = $data;
		$this->status  = $status;
		$this->headers = $headers;
	}

	/**
	 * @return null
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param null $token
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}

	/**
	 * @return array
	 */
	public function getCredentials()
	{
		return $this->credentials;
	}

	/**
	 * @param array $credentials
	 */
	public function setCredentials($credentials)
	{
		$this->credentials = $credentials;
	}

	/**
	 * @param null $data
	 * @param null $status
	 * @param null $headers
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function response($data = null, $status = null, $headers = null)
	{
		$data    = isset($data) ? $this->getData() : $data;
		$status  = isset($status) ? $this->getStatus() : $status;
		$headers = isset($headers) ? $this->getHeaders() : $headers;

		return Response::json($data, $status, $headers);
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param array $data
	 */
	public function setData($data)
	{
		$this->data = $data;
	}

	/**
	 * @return int
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @param int $status
	 */
	public function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * @param array $headers
	 */
	public function setHeaders($headers)
	{
		$this->headers = $headers;
	}

	public function downloadDetail($data = null, $filename = 'Detalle', $fecha = null, $title = 'Detalle campaña', $sheetName = 'Detalle')
	{
		if (!isset($data) && !count($data)) {
			return false;
		}
		if (!isset($fecha)) {
			$fecha = Carbon::now()->toDateString();
		}
		$filename = $filename . '_' . $fecha;
		Excel::create($filename, function ($excel) use ($data, $title, $sheetName) {
			$excel->setTitle($title)->setCreator('DPinto')->setCompany('Intelidata')->setDescription($title)->sheet($sheetName, function ($sheet) use ($data) {
				$sheet->setColumnFormat(array('A' => '@', 'B' => '0', 'C' => '0.00', 'D' => 'yy/mm/dd;@', 'E' => '@', 'F' => '@', 'G' => '@', 'H' => '@'));
				$sheet->fromArray($data, null, 'A1', false, false);
				$sheet->prependRow(array('Campaña', 'Negocio', 'Fecha Despacho ', 'Fecha Retención ', 'Email', 'Leído', 'Retenido', 'Fallido'));
				$sheet->freezeFirstRow();
				$sheet->setAutoSize(true);
				$sheet->setAutoFilter();
				$sheet->setAllBorders('thin');
			});
		})->download('xlsx');
	}

}
