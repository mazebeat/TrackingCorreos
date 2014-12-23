@extends('layouts.master')

@section('title')
    Inicio
@endsection

@section('content')
    <div ng-controller="adminController">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:"></a>
				</span>
            </div>
            <div class="panel-body">
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
        PNotify.removeAll();
        if ($.cookie('firstTime') != 'false') {
            new PNotify({
                type: 'notice',
                title: 'Aplicación iniciada',
                text: 'Bienvenido {{ Auth::user()->nombre }}!',
                position_animate_speed: 200,
                animate_speed: "fast",
                desktop: {
                    desktop: true
                }
            });

            $.cookie('firstTime', 'false');
        }
    </script>
@endsection
