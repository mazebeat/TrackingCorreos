<?php namespace App\Util;

use Illuminate\Auth\GenericUser;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserProviderInterface;
use Illuminate\Support\Facades\Session;

/**
 * Class DummyAuthProvider
 *
 * @package App\Util
 */
class DummyAuthProvider implements UserProviderInterface
{
	/**
	 * @var
	 */
	private $credentials;


	/**
	 * @param mixed $identifier
	 *
	 * @return \Illuminate\Auth\GenericUser
	 */
	public function retrieveById($identifier)
	{
		return $this->dummyUser();
	}

	/**
	 * @return \Illuminate\Auth\GenericUser
	 */
	protected function dummyUser()
	{
		$this->credentials = Session::get('credentials');

		$attributes = array('type'                  => $this->credentials['type'],
		                    'id'                    => $this->credentials['idUsuario'],
		                    'rut'                   => $this->credentials['rut'],
		                    'usuario'               => $this->credentials['usuario'],
		                    'tipoUsuario'           => $this->credentials['tipoUsuario'],
		                    'password'              => \Hash::make($this->credentials['password']),
		                    'mail'                  => $this->credentials['mail'],
		                    'nombre'                => $this->credentials['nombre'],
		                    'apellido'              => $this->credentials['apellido'],
		                    'descripcion'           => $this->credentials['descripcion'],
		                    'perfil'                => $this->credentials['codigoprivilegio'],
		                    'descripcionprivilegio' => $this->credentials['descripcionprivilegio'],
		                    'empresa'               => $this->credentials['empresa'],
		                    'negocios'               => $this->credentials['negocios'],);

		return new GenericUser($attributes);
	}

	/**
	 * @param array $credentials
	 *
	 * @return \Illuminate\Auth\GenericUser
	 */
	public function retrieveByCredentials(array $credentials)
	{
		if (count($credentials) && Session::has('credentials')) {
			Session::flash('credentials', $credentials);

			return $this->dummyUser();
		}

		if (count($credentials)) {
			Session::put('credentials', $credentials);

			return $this->dummyUser();
		}
	}

	/**
	 * @param \Illuminate\Auth\UserInterface $user
	 * @param array                          $credentials
	 *
	 * @return bool
	 */
	public function validateCredentials(UserInterface $user, array $credentials)
	{
		return true;
	}

	/**
	 * @param mixed  $identifier
	 * @param string $token
	 *
	 * @return \Exception
	 */
	public function retrieveByToken($identifier, $token)
	{
		return new \Exception('not implemented');
	}

	/**
	 * @param \Illuminate\Auth\UserInterface $user
	 * @param string                         $token
	 *
	 * @return \Exception
	 */
	public function updateRememberToken(UserInterface $user, $token)
	{
		return new \Exception('not implemented');
	}
}
