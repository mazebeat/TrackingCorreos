@extends('layouts.master')

@section('title')
@endsection

@section('page-title')
<i class="fa fa-folder"></i> ...<span>Gestor Documental...</span>
@endsection

@section('breakcrumb')
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		@if(isset($message) && $message != '' && isset($sql) && !count($sql))
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<strong>Atención! </strong> {{ $message }}
		</div>
		@endif
		<div class="panel panel-danger">
			<div class="panel-heading">
				{{ Form::open(array('role' => 'form')) }}
				<div class="row">
					<div class="form-group col-xs-4 col-md-2">
						{{ Form::label('negocio', 'Negocio (*)', array('class' => 'control-label ')) }}
						{{ Form::select('negocio', array('' => '','fija' => 'Fija',  'movil' => 'Movil' ), Input::old('negocio'), array('class' => 'form-control negocio')) }}
						<small class="help-block">{{ $errors->first('negocio') }}</small>
					</div>
					<div class="form-group col-xs-3 col-md-3">
						{{ Form::label('fecha', 'Fecha (*)', array('class' => 'control-label')) }}
						<input type="text" name="fecha" value="{{ Input::old('fecha') }}" size="16" data-date-minviewmode="months" data-date-viewmode="months" data-date-format="yyyy-mm" class="form-control form-control-inline input-medium default-date-picker" autocomplete='off'>
						<small class="help-block">{{ $errors->first('fecha') }}</small>
					</div>
					<div class="form-group col-xs-3 col-md-2">
						{{ Form::label('ciclo', 'ciclo (*)', array('class' => 'control-label')) }}
						{{ Form::select('ciclo', array(), Input::old('ciclo'), array('class' => 'form-control ciclo', 'disabled'))  }}
						{{--{{ Form::select('ciclo', array(), Input::old('ciclo'), array('class' => 'form-control ciclo'))  }}--}}
						<small class="help-block">{{ $errors->first('ciclo') }}</small>
					</div>
					<div class="form-group col-xs-1 col-md-1" style="margin-top: 24px;">
						{{ Form::label('consultar', 'Consultar', array('class' => 'control-label sr-only' )) }}
						<button type="submit" class="btn btn-default">Consultar</button>
					</div>
				</div>
				{{ Form::close() }}
				<span class="tools pull-right">
					<a class="fa fa-chevron-down" href="javascript:"></a>
				</span>
			</div>
			@if(isset($sql) && count($sql))
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<th>Negocio</th>
							<th>Fecha</th>
							<th>Ciclo</th>
							<th>Tipo Documento</th>
							<th>Total Envios</th>
							<th>Total Rebotes</th>
							<th>Total Leído</th>
						</thead>
						<tbody>
							@foreach($sql as $key => $value)
							<tr>
								<td>{{ $value->negocio }}</td>
								<td>{{ $value->fecha }}</td>
								<td>{{ $value->ciclo }}</td>
								<td>{{ $value->tipodoc }}</td>
								<td>{{ $value->qenvios }}</td>
								<td>{{ $value->rebotes }}</td>
								<td>{{ $value->leidos }}</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			@endif
		</div>

	</div>
</div>
@endsection

@section('file-style')
{{ HTML::style('js/bootstrap-datepicker/css/datepicker.css') }}
{{ HTML::style('js/bootstrap-datepicker/css/datepicker-custom.css') }}
@endsection

@section('text-style')
<style>
</style>
@endsection

@section('file-script')
<!--pickers plugins-->
{{ HTML::script('js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
{{ HTML::script('js/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js', array('charset' => 'UTF-8')) }}
{{ HTML::script('js/bootstrap-daterangepicker/moment.min.js') }}

<!--pickers initialization-->
{{ HTML::script('js/pickers-init.js') }}
@endsection

@section('text-script')
<script>
	var ciclo_fija = [{'0001': '0001', '0004': '0004', '0008': '0008'}];
	var ciclo_movil = [{'1': '1', '13': '13', '20': '20'}];
	var data = [];
	var complete = function () {
		if ($('.negocio').val() != '' && $('.ciclo').val() == null) {
			$('.ciclo').empty();
			var value = $('.negocio').val();
			if (value == '' || value == null) {
				$('.ciclo').empty().prop('disabled', 'disabled');
				data = [];
			} else {
				if (value.indexOf('fija') != -1) {
					data = ciclo_fija;
				}

				if (value.indexOf('movil')!= -1) {
					data = ciclo_movil;
				}

				if (data.length > 0) {
					$('.ciclo').append($("<option value=\"\"></option>"));
					$.each(data[0], function (key, value) {
						$('.ciclo').append($("<option value=\"" + key + "\">" + value + "</option>"));
					});
					$('.ciclo').removeAttr('disabled');
					data = [];
				} else {
					$('.ciclo').empty().prop('disabled', 'disabled');
				}
			}
		}
	};

	complete();

	$('.negocio').on('change', function (event) {
		$('.ciclo').empty();
		var value = $(this).val().toLowerCase();
		if (value == '' || value == null) {
			$('.ciclo').empty().prop('disabled', 'disabled');
			data = [];
		} else {
			if (value.indexOf('fija') != -1) {
				data = ciclo_fija;
			}

			if (value.indexOf('movil')!= -1) {
				data = ciclo_movil;
			}

			if (data.length > 0) {
				$('.ciclo').append($("<option value=\"\"></option>"));
				$.each(data[0], function (key, value) {
					$('.ciclo').append($("<option value=\"" + key + "\">" + value + "</option>"));
				});
				$('.ciclo').removeAttr('disabled');
				data = [];
			} else {
				$('.ciclo').empty().prop('disabled', 'disabled');
			}
		}

		event.preventDefault();
	});
</script>
@endsection
