@extends('layouts.master')

@section('title')
    Tracking
@endsection

@section('content')
    <div ng-controller="trackingController">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Tracking
                        <span class="tools pull-right">
							<a class="fa fa-chevron-down" href="javascript:"></a>
						</span>
                    </div>
                    <div class="panel-body">
                        <form role="form" name="trackingForm" ng-submit="submit()">
                            <div class="row">
                                <div class="form-group col-xs-3 col-md-3"
                                     ng-class="{ 'has-error' : trackingForm.fecha.$invalid && !trackingForm.fecha.$pristine }">
                                    {{ Form::label('fecha', 'Fecha (*)', array('class' => 'control-label')) }}
                                    <input type="text" name="fecha" value="{{ Input::old('fecha') }}" size="16"
                                           ng-model='tracking.fecha'
                                           data-date-minviewmode="months" data-date-viewmode="months"
                                           data-date-format="yyyy-mm"
                                           class="form-control form-control-inline input-medium default-date-picker ng-dirty ng-invalid"
                                           autocomplete='off'
                                           required>
                                    <small class="help-block">{{ $errors->first('fecha') }}</small>
                                </div>
                                <div class="form-group col-xs-3 col-md-3"
                                     ng-class="{ 'has-error' : trackingForm.campana.$invalid && !trackingForm.campana.$pristine }">
                                    {{ Form::label('campana', 'Campaña (*)', array('class' => 'control-label')) }}
                                    <select name="campana" class="form-control ng-dirty ng-invalid"
                                            ng-model="tracking.campana"
                                            ng-options="item.campana as item.campana for item in campanas" required>
                                        <option value="" selected>Seleccione una Campaña</option>
                                    </select>
                                    <small class="help-block">{{ $errors->first('campana') }}</small>
                                </div>
                                <div class="form-group col-xs-1 col-md-1" style="margin-top: 24px;">
                                    {{ Form::label('consultar', 'Consultar', array('class' => 'control-label sr-only' )) }}
                                    <button id="trackingFormButton" type="submit" class="ladda-button btn btn-success"
                                            data-style="zoom-in" data-size="xs"
                                            ng-disabled="trackingForm.$invalid">
                                        Consultar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default" ng-show="result">
                    <div class="panel-heading">
                        Resultado de busqueda
                         <span class="tools pull-right">
							<a class="fa fa-chevron-down" href="javascript:"></a>
						</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Año</th>
                                    <th>Mes</th>
                                    <th>Ciclo</th>
                                    <th>Q doc. Emitidos</th>
                                    <th>Q Físicos</th>
                                    <th>Q Electrónicos</th>
                                    <th>Visualizacion Mail</th>
                                    <th>Visualizacion Portal</th>
                                    <th>Lecturas Email</th>
                                    <th>No Leídos</th>
                                    <th>Retenidos</th>
                                    <th>Env. Fallidos</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="row in result">
                                    <td>@{{$index}}</td>
                                    <td>@{{row.ano}}</td>
                                    <td>@{{row.mes}}</td>
                                    <td>@{{row.ciclo}}</td>
                                    <td>@{{row.qemitidos}}</td>
                                    <td>@{{row.qfisicos}}</td>
                                    <td>@{{row.qelectronicos}}</td>
                                    <td>@{{row.ciclo}}</td>
                                    <td>@{{row.ciclo}}</td>
                                    <td>@{{row.qleidos}}</td>
                                    <td>@{{row.qnoleidos}}</td>
                                    <td>@{{row.qrebotes}}</td>
                                    <td>@{{row.qenviosfallidos}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
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
    <script type="text/javascript">
        var trackingButton = Ladda.create(document.querySelector('#trackingFormButton'));
        Ladda.bind('.ladda-button');
    </script>
@endsection
