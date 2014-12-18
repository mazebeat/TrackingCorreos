<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="iso-8859-1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>

	{{ HTML::style('css/bootstrap.min.css') }}
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" />
	<!--[if IE 7]>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" />
	<![endif]-->

    {{ HTML::script('js/modernizr.min.js') }}

    @yield('file-style')

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	@yield('text-style')
</head>
<body id="{{ \App\Util\SiteHelpers::bodyId() }}" class="signin" ng-app="trackingCorreos">
	{{--@include('layouts.preloader')--}}
    <div class="container">
	    @yield('content')
    </div>

	{{ HTML::script('js/jquery-1.10.2.min.js') }}
	{{ HTML::script('js/jquery-migrate-1.2.1.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}

	@yield('file-script')

    @include('layouts.angularjs')

	@yield('text-script')
</body>
</html>
