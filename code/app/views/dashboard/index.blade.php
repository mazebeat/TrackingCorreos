@extends('layouts.simple')

@section('title')
Inicio
@endsection

@section('page-title')
<i class="fa fa-home"></i> Inicio<span>Gestor Documental...</span>
@endsection

@section('breakcrumb')
@endsection

@section('content')
<h2>Bienvenido al Gestor Documental de Movistar</h2>
{{ var_dump(Auth::user()) }}
@endsection

@section('text-script')
<script type="text/javascript">
</script>
@endsection
