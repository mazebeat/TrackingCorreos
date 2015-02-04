<?php

use App\Util\XLSXWriter;
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

	/**
	 * @param null   $data
	 * @param string $filename
	 * @param null   $fecha
	 * @param string $title
	 * @param string $sheetName
	 *
	 * @return bool
	 */
	public function downloadDetail($data = null, $filename = 'Detalle', $fecha = null, $title = 'Detalle campaña', $sheetName = 'Detalle')
	{
		include_once(app_path() . '/utils/xlsxwriter.class.php');

		if (!isset($data) && !count($data)) {
			return false;
		}
		if (!isset($fecha)) {
			$fecha = Carbon::now()->toDateString();
		}
		$filename = $filename . '_' . $fecha . '.xlsx';
		$header   = array('Campaña' => 'string', 'Negocio' => 'string', 'Fecha Despacho' => 'string', 'Fecha Retención' => 'string', 'Email' => 'string', 'Leído' => 'string', 'Retenido' => 'string', 'Fallido' => 'string',);
		$writer   = new \XLSXWriter();
		$writer->writeSheetHeader($sheetName, $header);
		foreach ($data as $value) {
			$writer->writeSheetRow($sheetName, array(utf8_encode($value->NCampana), utf8_encode($value->NNegocio), $value->fechaDespacho, $value->fechaRetencion, utf8_encode($value->mail), 'NO', 'NO', 'NO'));
		}
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-Type: application/octet-stream');
		header('Content-Type: application/download');
		header('Content-type: application/ms-excel;');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Pragma: public');
		header('Cache-Control: max-age=0');
		header('Expires: 0');
		$writer->writeToStdOut();
		exit;
		//		echo '#' . floor((memory_get_peak_usage()) / 1024 / 1024) . "MB" . "\n";
	}

	public static function printExcel($table, $filename) {
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-Type: application/octet-stream');
		header('Content-Type: application/download');
		header('Content-type: application/ms-excel;');
		header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
		header('Pragma: public');
		header('Cache-Control: max-age=0');
		header('Expires: 0');

//		header("Content-type: application/octet-stream");
//		header("Content-Disposition: attachment; filename=" . $filename . ".xls");
//		header("Pragma: no-cache");
//		header("Expires: 0");

		echo $table;
		exit;
	}
}
