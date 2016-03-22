@extends('tablas')

@section('stylesheets')

<!-- <link href="{!! asset('/assets/css/tablas/style.css') !!}" rel="stylesheet"> -->

@endsection

@section('content')

<div ng-app="tablasTorneo" ng-controller="goleadoresController as tbl" ng-init="tbl.init({{$torneo}}, {{$cliente}})" class="container"> 
	<!-- ng-style="tbl.containerStyle"> -->

	<header class="row titulo" ng-style="tbl.headerStyle">
		<strong><div class="text-center col-xs-14 col-xs-offset-2">@{{ tbl.torneo.tor_nombre | uppercase}}</div></strong>
	</header>

	<main>
		<!-- <section class="row posiciones"> -->
		<section class="row">

			<table class="table table-hover">
				<!-- <tr class="header-tabla" ng-style="tbl.headerTablaStyle"> -->
				<thead>
					<tr>
						<td class="col-sm-1"></td>
						
						<td class="col-sm-4">Jugador</td>
						
						<td class="col-sm-1">Goles</td>

						<td class="col-sm-1"></td>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="jugador in tbl.posiciones">
						<td class="col-sm-1">@{{ $index + 1 }}</td>
						
						<td class="col-sm-4">@{{ jugador.jugador }}</td>

						<td class="col-sm-1">@{{ jugador.goles }}</td>

						<td class="col-sm-2 text-center">
							<img ng-src="/@{{ jugador.escudo }}" alt="@{{ jugador.equipo }}" style="max-width:20px;max-height:20px;"/>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="row">
				<div class="col-xs-6 text-right">
					<p class="text-center"><img src="/images/dataprensa.png" alt="DataPrensa logo"></p>
				</div>
			</div>

		</section>

	</main>
</div>

@endsection

@section('scripts')

<script src="{!! asset('/assets/js/tablas/mostrar/app.js') !!}"></script>
<script src="{!! asset('/assets/js/tablas/mostrar/exception.js') !!}"></script>
<script src="{!! asset('/assets/js/tablas/goleadores/factory.js') !!}"></script>
<script src="{!! asset('/assets/js/tablas/goleadores/controller.js') !!}"></script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-74410923-1', 'auto');
ga('send', 'pageview');

</script>

@endsection
