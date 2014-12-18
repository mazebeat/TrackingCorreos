@extends('layouts.master')

@section('title')
    Inicio
@endsection

@section('text-style')
    <style>
        .popover-all {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1010;
            display: none;
            padding: 5px;
        }

        .popover-all.bottom {
            margin-top: 5px;
        }

        .popover-all.bottom .popover-arrow {
            top: 0;
            left: 93%;
            margin-left: -5px;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid #000000;
        }

        .popover-all .popover-arrow {
            position: absolute;
            width: 0;
            height: 0;
        }

        .popover-inner {
            padding: 3px;
            width: 500px;
            overflow: hidden;
            background: #000000;
            background: rgba(0, 0, 0, 0.8);
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
            -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
            -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
        }

        .popover-title {
            padding: 8px 14px;
            margin: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 18px;
            background-color: #ffffff;
            border-bottom: 1px solid #ebebeb;
            -webkit-border-radius: 5px 5px 0 0;
            -moz-border-radius: 5px 5px 0 0;
            border-radius: 5px 5px 0 0;
        }

        .popover-content {
            padding: 9px 14px;
            background-color: #ffffff;
            -webkit-border-radius: 0 0 3px 3px;
            -moz-border-radius: 0 0 3px 3px;
            border-radius: 0 0 3px 3px;
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding-box;
            background-clip: padding-box;
        }
    </style>
@endsection

@section('breakcrumb')
@endsection

@section('content')
    <div ng-controller="adminController">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>" {{ Auth::user()->nombre }} ", Bienvenido al nuevo Trancking de Correos</h4>
            </div>
            <div class="panel-body">
            </div>
        </div>
    </div>
@endsection

@section('text-script')
    <script type="text/javascript">
    </script>
@endsection
