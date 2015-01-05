@extends('layouts.master')

@section('title')
@endsection

@section('content')
@if ($errors->has())
@if($errors->any())
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<strong>Atención! </strong><br>
	{{ HTML::ul($errors->all()) }}
</div>
@endif
@endif

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-danger">
			<header class="panel-heading">
				Editar {{ $user->usuario }}
				<span class="tools pull-right">
					<a class="fa fa-arrow-left" href="{{ URL::previous() }}"> Volver</a>
					{{--<a href="javascript:;" class="fa fa-chevron-down"></a>--}}
					{{--<a href="javascript:;" class="fa fa-times"></a>--}}
				</span>
			</header>
			<div class="panel-body">
				{{ Form::model($user, array('route' => array('admin.usuarios.update', $user->idUsuario), 'method' => 'PUT', 'role' => 'form')) }}
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							{{ Form::label('usuario', 'Usuario') }}
							{{ Form::text('usuario', null, array('class' => 'form-control')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							{{ Form::label('nombre', 'Nombre') }}
							{{ Form::text('nombre', null, array('class' => 'form-control')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::label('apellido', 'Apellido') }}
							{{ Form::text('apellido', null, array('class' => 'form-control')) }}
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							{{ Form::label('rut', 'RUT') }}
							{{ Form::text('rut', null, array('class' => 'form-control', 'readonly')) }}
						</div>
						<div class="col-sm-6">
							{{ Form::label('mail', 'Email') }}
							{{ Form::email('mail', null, array('class' => 'form-control')) }}
						</div>
					</div>
				</div>				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							{{ Form::label('idTipoUsuario', 'Tipo Usuario') }}
							{{ Form::select('idTipoUsuario', isset($tipouser) ? $tipouser : array() ,null,  array('class' => 'form-control')) }}
						</div>
					</div>
				</div>
				{{ Form::submit('Editar Usuario', array('class' => 'btn btn-primary pull-right')) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection
