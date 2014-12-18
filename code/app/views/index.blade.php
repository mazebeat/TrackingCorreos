@extends('layouts.simple')

@section('title')
@endsection

@section('text-style')
<style>
</style>
@endsection

@section('file-style')
@endsection

@section('content')
<div ng-controller="homeController">
    <p>@{{ message }}</p>
    {{-- Open form --}}
    <form ng-submit="submit()">
    {{-- Username input --}}
    <div class="form-group" ng-class="{ 'has-error': loginForm.username.$invalid, 'has-success' : !loginForm.username.$invalid }">
    <input type="text" name="username" id="username" ng-model="user.user" class="form-control ng-dirty ng-invalid" placeholder="Usuario" required>
    {{-- Password input --}}
    <div class="form-group" ng-class="{ 'has-error': loginForm.password.$invalid, 'has-success' : !loginForm.password.$invalid }">
         <input type="password" name="password" id="password" ng-model="user.password" class="form-control ng-dirty ng-invalid" placeholder="Contraseña" required>
    </div>
    <button type="submit" ng-disabled="loginForm.$invalid" class="btn btn-success btn-block" id="loginFormButton">Iniciar Sesión</button>
    {{-- Close form --}}
    </form>
    </div>
@endsection

@section('file-script')
@endsection

@section('text-script')
<script type="text/javascript">
// var url = 'http://192.168.4.104:9900/GestionMailWS/login/validauser/';
// var url = 'http://192.168.1.99:9800/GestionMailWS/login/validauser/';
// var data = 'user=test&password=123';
//jQuery.ajax({
//   type: 'POST',
//   url: url,
//   data: datas,
//   success: function (data, status, jqXHR) {
//       console.log(data);
//       console.log(status);
//       console.log(jqXHR);
//   },
//   error: function (data, status, jqXHR) {
//       console.log(data);
//       console.log(status);
//       console.log(jqXHR);
//   }
//});
// $.post(url, data, function(response) {
//    console.log(response)
// }, 'json');
</script>
@endsection
