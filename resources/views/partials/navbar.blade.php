<nav class="navbar navbar-default navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Dataprensa</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="{{ url('lugares') }}">Lugares</a></li>
				<li><a href="{{ url('estadios') }}">Estadios</a></li>
				<li><a href="{{ url('equipos') }}">Equipos</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Torneos <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('tipo_torneo') }}">Tipo de torneo</a></li>
						<li><a href="{{ url('torneos') }}">Torneos</a></li>
						<li><a href="{{ url('torneos/config') }}">Wizard Torneos</a></li>
						<li><a href="{{ url('tipo_fase') }}">Tipo de fase</a></li>
						<li><a href="{{ url('fases') }}">Fases</a></li>
						<li><a href="{{ url('jugadores') }}">Jugadores</a></li>
						<li><a href="{{ url('plantillas/config') }}">Configuración Plantillas</a></li>
						<li><a href="{{ url('partidos/wizard') }}">Wizard Partidos</a></li>
						<li><a href="{{ url('fechas') }}">Fechas</a></li>
						<li><a href="{{ url('tablas') }}">Tablas de posición</a></li>
					</ul>
				</li>
				@if (Auth::check() && Auth::user()->isAdmin())
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Clientes <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('clientes') }}">Lista de clientes</a></li>
						<li><a href="{{ url('auspiciantes') }}">Lista de auspiciantes</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Previews <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('clientes') }}">Lista de clientes</a></li>
						<li><a href="{{ url('auspiciantes') }}">Lista de auspiciantes</a></li>
						<li><a href="{{ url('clientes/wizard') }}">Wizard de Clientes</a></li>
					</ul>
				</li>
				@endif
			</ul>

			<ul class="nav navbar-nav navbar-right">
				@if (Auth::guest())
				<li><a href="{{ url('/auth/login') }}">Login</a></li>
				@else
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
					</ul>
				</li>
				<li><a href="{{ url('/auth/register') }}">Register</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>
