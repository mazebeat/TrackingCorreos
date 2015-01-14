@extends('layouts.master')

@section('title')
    Inicio
@endsection

@section('content')
    <div ng-controller="adminController">
        <div class="panel panel-default">
            <div class="panel-heading">
                Estadisticas mensuales
                <span class="tools pull-right">
                <a class="fa fa-question" id="dashboardTour" href="javascript:"></a>
                <a class="fa fa-chevron-down" href="javascript:"></a>
                </span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    @{{ ididnegocio }}
                                    {{--{{ Form::label('negocios', 'Negocios (*)', array('class' => 'control-label')) }}--}}
                                    <select name="negocios" class="form-control ng-dirty ng-invalid"
                                            ng-model="negocio"
                                            ng-options="item as item for item in negocios"
                                            ng-change="changeChart()"
                                            required>
                                        <option value="" selected>Seleccione un Negocio</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 pull-right">
                                <div class="btn-group export">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="fa fa-download"></i> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="exportG1Pdf" href="#">PDF</a></li>
                                        <li><a id="exportG1Jpg" href="#">JPG</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="chartdiv1" style="width: 100%; height: 400px; background-color: #FFFFFF;"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="searchsForm" name="searchForm" ng-submit="submit()" class="form-inline">
                                    <div class="form-group">
                                        {{ Form::label('months', 'Meses', array('class' => 'control-label col-xs-2')) }}
                                        <div id="months" class="col-xs-6">
                                            <div class="input-group">
                                                <div class="spinner-buttons input-group-btn">
                                                    <button class="btn spinner-down" type="button">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" readonly="" maxlength="3"
                                                       class="spinner-input form-control">

                                                <div class="spinner-buttons input-group-btn">
                                                    <button class="btn spinner-up" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" ng-disabled="searchForm.$invalid" id="searchFormButton"
                                                class="btn btn-warning ladda-button" data-style="zoom-in" data-size="s">
                                            <span class="ladda-label"><i class="fa fa-refresh"></i></span>
                                        </button>
                                    </div>
                                    <div class="pull-right">
                                        <div class="btn-group export">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fa fa-download"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a id="exportG2Pdf" href="#">PDF</a></li>
                                                <li><a id="exportG2Jpg" href="#">JPG</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <div id="chartdiv2"
                                     style="width: 100%; height: 400px; background-color: #FFFFFF;"></div>
                            </div>
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
    {{--Spineer JS --}}
    {{ HTML::script('js/fuelux/js/spinner.min.js') }}
    {{ HTML::script('js/spinner-init.js') }}
    {{--Datepicker JS --}}
    {{ HTML::script('js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
    {{ HTML::script('js/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js', array('charset' => 'UTF-8')) }}
    {{--Datepicker init --}}
    {{ HTML::script('js/pickers-init.js') }}
@endsection

@section('text-script')
    <script type="text/javascript">
        var searchButton = Ladda.create(document.querySelector('#searchFormButton'));
        Ladda.bind('.ladda-button');
        var chartdiv1 = new AmCharts.AmPieChart();
        var chartdiv2 = new AmCharts.AmSerialChart();

        {{--if ($.cookie('firstTime')) {--}}
        {{--$(function () {--}}
        {{--var notice = (new PNotify({--}}
        {{--type: 'notice',--}}
        {{--title: 'Aplicación iniciada',--}}
        {{--text: 'Bienvenido {{ Auth::user()->nombre }}!',--}}
        {{--desktop: {--}}
        {{--desktop: true--}}
        {{--}--}}
        {{--}));--}}

        {{--$.cookie('firstTime', false);--}}
        {{--});--}}
        {{--}--}}
    </script>
@endsection
