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
    @yield('file-style')
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/style_responsive.css') }}
    {{ HTML::script('js/modernizr.min.js') }}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {{  HTML::script('js/html5shiv.js') }}
    {{  HTML::script('js/respond.min.js') }}
    <![endif]-->
    @yield('text-style')
</head>
<body id="{{ \App\Util\SiteHelpers::bodyId() }}" class="horizontal-menu-page" ng-app="trackingCorreos">
<section>
    @include('layouts.preloader')
    <div class="wrapper-top">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4">
                {{ HTML::image('images/login-logo.png', 'Intelidata', array('class' => 'img-responsive')) }}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <h2 class="text-center">Tracking de correos</h2>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4">
                {{ HTML::image('http://madrynsite.com.ar/wp-content/uploads/2013/04/Logo_Telefonica_Movistar1.jpg', 'Intelidata', array('class' => 'img-responsive pull-right', 'style' => 'height: 81px;')) }}
            </div>
        </div>
    </div>
    @include('layouts.master_modules.menu')
    <div class="wrapper">
        @yield('content')
    </div>
    <footer class="sticky-footer">
        @include('layouts.master_modules.footer')
    </footer>
</section>
{{ HTML::script('js/jquery-1.10.2.min.js') }}
{{ HTML::script('js/jquery-ui-1.10.3.min.js') }}
{{ HTML::script('js/jquery-migrate-1.2.1.min.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
@yield('file-script')
@include('layouts.angularjs')
{{ HTML::script('js/scripts.js') }}
@yield('text-script')
</body>
</html>
