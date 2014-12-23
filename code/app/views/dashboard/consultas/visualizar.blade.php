@extends('layouts.master')

@section('title')
    Visualizacion Documentos
@endsection

@section('text-style')
<style>
</style>   
@endsection

@section('content')
    <div ng-controller="visualizaController">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Visualización de Documentos
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:"></a>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form role="form" ng-submit="submit()">
                            <div class="row">
                                <div class="form-group col-xs-3 col-md-2">
                                    {{ Form::label('folio', 'Folio', array('class' => 'control-label')) }}
                                    <input type="text" name="folio" id="folio" class="form-control"/>
                                    <small class="help-block">{{ $errors->first('folio') }}</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-1 col-md-1">
                                    {{ Form::label('consultar', 'Consultar', array('class' => 'control-label sr-only' )) }}
                                    <button type="submit" class="btn btn-default">Consultar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footing">
                        <p class="help-block" style="font-size: 20px">Resultado Búsqueda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('text-script')
    <script type="text/javascript">
    </script>
@endsection
