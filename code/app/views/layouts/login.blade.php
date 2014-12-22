<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="Aplicación Reportes Despachos">
	<meta name="author" content="Intelidata">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.png" type="image/png">
	<title>@yield('title')</title>
	{{ HTML::style('css/style.css') }}
	{{ HTML::style('css/style_responsive.css') }}
	{{ HTML::style('js/ladda/dist/ladda.min.css') }}
	{{ HTML::style('js/pNotify/css/pnotify.custom.min.css') }}

	{{ HTML::script('js/modernizr.min.js') }}
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	{{ HTML::script('js/html5shiv.js') }}
	{{ HTML::script('js/respond.min.js') }}
	<![endif]-->
</head>
<body id="{{ \App\Util\SiteHelpers::bodyId() }}" class="login-body" ng-app="trackingCorreos">
	{{--@include('layouts.preloader')--}}
	<div class="container">
		@yield('content')
	</div>
	{{ HTML::script('js/jquery-1.10.2.min.js') }}
	{{ HTML::script('js/jquery-ui-1.10.3.min.js') }}
	{{ HTML::script('js/jquery-migrate-1.2.1.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	{{ HTML::script('js/jquery.cookies.js') }}
	{{ HTML::script('js/ladda/dist/spin.min.js') }}
	{{ HTML::script('js/ladda/dist/ladda.min.js') }}
	{{ HTML::script('js/pNotify/js/pnotify.custom.min.js') }}
	@yield('file-script')
	@include('layouts.angularjs')
	<script>
		PNotify.desktop.permission();
	</script>
	@yield('text-script')
</body>
</html>
