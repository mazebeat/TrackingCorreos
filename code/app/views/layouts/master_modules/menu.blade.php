<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ URL::to('dashboard') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search fa-fw"></i> Consultas <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('dashboard/consultas/individual') }}">Consulta Individual</a></li>
                        <li><a href="{{ URL::to('dashboard/consultas/historica') }}">Consulta Histórica</a></li>
                        <li class="divider" role="presentation"></li>
                        <li><a href="{{ URL::to('dashboard/consultas/visualizacion') }}">Visualización de documentos</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart-o fa-fw"></i> Reportes <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('dashboard/reportes/electronicos') }}">Lectura de Documentos
                                electrónicos</a></li>
                        <li><a href="{{ URL::to('dashboard/reportes/fisicos') }}">Lectura de Documentos Despacho
                                Físico</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope fa-fw"></i> Tracking <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('dashboard/tracking/electronicos') }}">Tracking de envíos
                                electrónicos</a></li>
                        <li><a href="{{ URL::to('dashboard/tracking/fisicos ') }}">Tracking de envíos físicos</a></li>
                    </ul>
                </li>

                @if(Auth::check() && Auth::user()->perfil == 'ADM')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-fw"></i> Administración <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('dashboard/administracion/cambiopass') }}">Cambio contraseñas</a>
                            </li>
                            <li><a href="{{ URL::to('dashboard/administracion/usuarios ') }}">Administración
                                    usuarios</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user fa-lg fa-fw"
                           style="color: #FFFFFF;"></i> {{ Str::upper(Auth::user()->nombre)  }}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('logout') }}">Salir</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="helpPopover" type="button" class="" data-toggle="popover">
                        <i class="fa fa-question"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
