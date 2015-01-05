@extends('layouts.master')

@section('title')
@endsection

@section('content')
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-danger">
			<header class="panel-heading">
				Usuarios
				<span class="tools pull-right">
					<a class="fa fa-plus" href="{{ URL::to('admin/usuarios/create') }}"> Nuevo</a>
					{{--<a href="javascript:;" class="fa fa-chevron-down"></a>--}}
					{{--<a href="javascript:;" class="fa fa-times"></a>--}}
				</span>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Email</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $key => $value)
							<tr>
								<td>{{ $value->idUsuario }}</td>
								<td>{{ $value->nombre }}</td>
								<td>{{ $value->mail }}</td>
								<td>
									<div class="pull-right">
										{{ Form::open(array('url' => 'admin/usuarios/' . $value->idUsuario, 'class' => 'pull-right')) }}
										{{ Form::hidden('_method', 'DELETE') }}
										{{ HTML::button('submit', '<i class="fa fa-trash fa-fw"></i>Borrar', array('class' => 'btn btn-warning')) }}
										{{ Form::close() }}										
										<a class="btn btn-small btn-success" href="{{ URL::to('admin/usuarios/' . $value->idUsuario) }}"><i class="fa fa-eye fa-fw"></i>Ver</a>
										<a class="btn btn-small btn-info" href="{{ URL::to('admin/usuarios/' . $value->idUsuario . '/edit') }}"><i class="fa fa-pencil fa-fw"></i>Editar</a>&nbsp;
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
