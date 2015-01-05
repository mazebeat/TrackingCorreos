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
                <li id="menuHome" class="{{ HTML::activeLink('dashboard') }}"><a href="{{ URL::to('dashboard') }}"><i
                                class="fa fa-home fa-fw"></i> Inicio</a></li>
                <li id="menuConsultas"
                    class="dropdown {{ HTML::activeState(array('dashboard/consultas/individual', 'dashboard/consultas/historica', 'dashboard/consultas/visualizacion')) }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search fa-fw"></i>
                        Consultas <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('dashboard/consultas/individual') }}">Consulta Individual</a></li>
                        <li><a href="{{ URL::to('dashboard/consultas/historica') }}">Consulta Histórica</a></li>
                        <li class="divider" role="presentation"></li>
                        <li><a href="{{ URL::to('dashboard/consultas/visualizacion') }}">Visualización de documentos</a>
                        </li>
                    </ul>
                </li>
                <li id="menuReportes"
                    class="dropdown {{ HTML::activeState(array('dashboard/reportes', 'dashboard/reportes/lecturatot')) }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart-o fa-fw"></i>
                        Reportes <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('dashboard/reportes/lecturatot') }}">Lectura total de Documentos</a>
                        </li>
                    </ul>
                </li>
                <li id="menuTracking" class="{{ HTML::activeLink('dashboard/tracking') }}"><a
                            href="{{ URL::to('dashboard/tracking') }}"><i class="fa fa-envelope fa-fw"></i>
                        Tracking</a></li>
                @if(Auth::check() && Auth::user()->perfil == 'ADM')
                    <li id="menuAdmin"
                        class="dropdown {{ HTML::activeState(array('dashboard/administracion/cambiopass', 'dashboard/administracion/usuarios')) }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-fw"></i>
                            Administración <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('dashboard/administracion/cambiopass') }}">Cambio contraseñas</a>
                            </li>
                            <li><a href="{{ URL::to('dashboard/administracion/usuarios') }}">Administración
                                    usuarios</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown" id="menuUsuario">
                    <a href="javascript;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user fa-lg fa-fw"
                           style="color: #FFFFFF;"></i> {{ Str::upper(Auth::user()->nombre)  }}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('logout') }}">Salir</a></li>
                    </ul>
                </li>
                <li id="menuHelp">
                    <a href="#" id="helpPopover" type="button" class="">
                        <i class="fa fa-question"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
