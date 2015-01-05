@extends('layouts.master')

@section('title')
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-danger">
			<header class="panel-heading">
				Ver: {{ $user->nombre }} {{ $user->apellido }}
				<span class="tools pull-right">
					<a class="fa fa-arrow-left" href="{{ URL::previous() }}"> Volver</a>
					{{--<a href="javascript:;" class="fa fa-chevron-down"></a>--}}
					{{--<a href="javascript:;" class="fa fa-times"></a>--}}
				</span>
			</header>
			<div class="panel-body">
				<h2>{{ $user->usuario }}</h2>
				<p><strong>Email:</strong> {{ $user->mail }}</p>
				<p><strong>RUT:</strong> {{ $user->rut }}</p>
				<p><strong>Tipo usuario:</strong> {{ $user->idTipoUsuario }}</p>
				<p><strong>Ultima conexión:</strong> {{ $user->ultimaconexion }}</p>
			</div>
		</div>
	</div>
</div>
@endsection
