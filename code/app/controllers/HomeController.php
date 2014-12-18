<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * Class HomeController
 */
class HomeController extends ApiController
{
	private $credentials;

	public function __construct()
	{
		parent::__construct();
		$this->credentials = $this->credentials;
	}


	public function index()
	{
		if (Auth::check()) {
			return Redirect::to('dashboard');
		}

		return View::make('index');
	}

	public function login()
	{
		$this->credentials = Input::all();

		if (Auth::attempt($this->credentials)) {
			$this->setData(array('message' => array('Autentificación correcta'),
			                     'ok'      => true));

			return Response::json($this->getData(), $this->getStatus(), $this->getHeaders());
		}
		$this->setData(array('message' => array('Autentificación fallida'),
		                     'ok'      => false));

		return Response::json($this->getData(), $this->getStatus(), $this->getHeaders());
	}

	/**
	 * @return mixed
	 */
	public function logout()
	{
		Auth::logout();
		Session::forget('credentials');

		return Redirect::to('/');
	}

}
