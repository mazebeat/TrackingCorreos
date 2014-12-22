@extends('layouts.simple')

@section('title')
	Tracking
@endsection

@section('content')
	<div ng-controller="trackingController">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<form role="form" ng-submit="submit()">
							<div class="row">
								<div class="form-group col-xs-4 col-md-2">
									{{ Form::label('empresa', 'Empresa (*)', array('class' => 'control-label ')) }}
									{{ Form::select('empresa', array('' => '','pcs' => 'PCS',  'entel' => 'Entel S.A', 'eph' => 'EPH'), Input::old('empresa'), array('class' => 'form-control empresa')) }}
									<small class="help-block">{{ $errors->first('empresa') }}</small>
								</div>
								<div class="form-group col-xs-3 col-md-3">
									{{ Form::label('fecha', 'Fecha (*)', array('class' => 'control-label')) }}
									<input type="text" name="fecha" value="{{ Input::old('fecha') }}" size="16"
									       data-date-minviewmode="months" data-date-viewmode="months"
									       data-date-format="yyyy-mm"
									       class="form-control form-control-inline input-medium default-date-picker"
									       autocomplete='off'>
									<small class="help-block">{{ $errors->first('fecha') }}</small>
								</div>
								<div class="form-group col-xs-3 col-md-2">
									{{ Form::label('ciclo', 'Ciclo (*)', array('class' => 'control-label')) }}
									{{ Form::select('ciclo', array(), Input::old('ciclo'), array('class' => 'form-control ciclo', 'disabled'))  }}
									<small class="help-block">{{ $errors->first('ciclo') }}</small>
								</div>
								<div class="form-group col-xs-1 col-md-1" style="margin-top: 24px;">
									{{ Form::label('consultar', 'Consultar', array('class' => 'control-label sr-only' )) }}
									<button type="submit" class="btn btn-default">Consultar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="panel-body">
					</div>
				</div>
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
	</script>
@endsection
