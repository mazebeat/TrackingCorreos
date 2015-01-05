@extends('layouts.master')

@section('title')
    Consulta individual
@endsection

@section('content')
    <div ng-controller="individualController">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        Consulta Individual
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:"></a>
				        </span>
                    </div>
                    <div class="panel-body">
                        <form role="form" ng-submit="submit()">
                            <div class="row">
                                <div class="form-group col-xs-4 col-md-2">
                                    {{ Form::label('empresa', 'Empresa (*)', array('class' => 'control-label ')) }}
                                    {{ Form::select('empresa', array('' => '','pcs' => 'PCS',  'entel' => 'Entel S.A', 'eph' => 'EPH'), Input::old('empresa'), array('class' => 'form-control empresa')) }}
                                    <small class="help-block">{{ $errors->first('empresa') }}</small>
                                </div>
                                <div class="form-group col-xs-3 col-md-2">
                                    {{ Form::label('cuenta', 'Cuenta', array('class' => 'control-label')) }}
                                    <input type="text" name="cuenta" value="{{ Input::old('cuenta') }}"
                                           class="form-control"
                                    <small class="help-block">{{ $errors->first('cuenta') }}</small>
                                </div>
                                <div class="form-group col-xs-1 col-md-2">
                                    {{ Form::label('tipodoc', 'Tipo Documento', array('class' => 'control-label')) }}
                                    {{ Form::select('tipodoc', array('' => '','bol' => 'BOLETA',  'fac' => 'FACTURA', 'nc' => 'NOTA DE CREDITO'), Input::old('tipodoc'), array('class' => 'form-control tipodoc')) }}
                                    <small class="help-block">{{ $errors->first('tipodoc') }}</small>
                                </div>
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
                                <div class="form-group col-xs-1 col-md-1">
                                    {{ Form::label('limpiar', 'Limpiar', array('class' => 'control-label sr-only' )) }}
                                    <button type="submit" class="btn btn-default">Limpiar</button>
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

@section('file-style')
@endsection

@section('text-style')
    <style>
    </style>
@endsection

@section('file-script')
@endsection

@section('text-script')
    <script>
    </script>
@endsection
