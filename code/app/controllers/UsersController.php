<?php

class UsersController extends \ApiController
{

	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();

		return View::make('users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		$tipouser = TipoUsuario::all()->lists('Descripcion', 'idTipoUsuario');

		return View::make('users.create', compact('tipouser'));
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		User::create($data);

		return Redirect::route('admin.usuarios.index');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);

		return View::make('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		$tipouser = TipoUsuario::all()->lists('Descripcion', 'idTipoUsuario');

		return View::make('users.edit', compact('user'))->with(compact('tipouser'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$user      = User::findOrFail($id);
		$rules     = array('usuario'  => 'required',
			'nombre'   => 'required',
			'apellido' => 'required',
			'rut'      => 'required|exists:Usuarios,rut',
			'mail'     => 'required|email');
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user->update($data);

		return Redirect::route('admin.usuarios.index');
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);

		return Redirect::route('admin.usuarios.index');
	}

}
