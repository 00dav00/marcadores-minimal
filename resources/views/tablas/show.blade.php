@extends('tablas')

@section('stylesheets')

<link href="{!! asset('/assets/css/tablas/style.css') !!}" rel="stylesheet">

@endsection

@section('content')

<div ng-app="tablasTorneo" ng-controller="tablasController as tbl" ng-init="tbl.init({{$torneo}}, {{$cliente}})" class="container" ng-style="tbl.containerStyle">

	<header class="row titulo" ng-style="tbl.headerStyle">
		<strong><div class="text-center col-xs-14 col-xs-offset-2">@{{ tbl.torneo.tor_nombre | uppercase}}</div></strong>
	</header>

	<main>
		<section class="row posiciones">

			<table class="table table-hover">
				<tr class="header-tabla" ng-style="tbl.headerTablaStyle">
					<th class="col-sm-1"></th>
					
					<th class="col-sm-2"></th>
					
					<th class="col-sm-4">Equipo</th>
					
					<th class="col-sm-1">PJ</th>

					<!--no se muestran cuando es sm-->
					<th class="col-sm-1 hidden-xs">PG</th>
					<th class="col-sm-1 hidden-xs">PE</th>
					<th class="col-sm-1 hidden-xs">PP</th>
					<th class="col-sm-1 hidden-xs">GF</th>
					<th class="col-sm-1 hidden-xs">GC</th>

					<th class="col-sm-1">GD</th>
					
					<th class="col-sm-1">Pts</th>
				</tr>
				<tr ng-repeat="equipo in tbl.equipos">
					<td class="col-sm-1">@{{ $index + 1 }}</td>
					
					<td class="col-sm-2 text-center"><img ng-src="/@{{ equipo.escudo }}" alt="@{{ equipo.abreviatura }}" style="max-width:20px;max-height:20px;"/></td>

					<td class="col-sm-4">@{{ equipo.nombre_corto }}</td>
					
					<td class="col-sm-1">@{{ equipo.partidos_jugados }}</td>

					<td class="col-sm-1 hidden-xs">@{{ equipo.partidos_ganados }}</td>
					<td class="col-sm-1 hidden-xs">@{{ equipo.partidos_empatados }}</td>
					<td class="col-sm-1 hidden-xs">@{{ equipo.partidos_perdidos }}</td>
					<td class="col-sm-1 hidden-xs">@{{ equipo.goles_favor }}</td>
					<td class="col-sm-1 hidden-xs">@{{ equipo.goles_contra }}</td>

					<td class="col-sm-1">@{{ equipo.goles_diferencia }}</td>

					<td class="col-sm-1">@{{ equipo.puntos }}</td>

				</tr>
			</table>

			<div class="row">
				<div class="col-xs-12 text-center">
					<div class="btn-group btn-group-sm" role="group" ng-repeat="fase in tbl.fases">
						<button class="btn btn-default botones" ng-click="tbl.cambiarFasePosiciones(fase)" ng-style="tbl.botonesStyle" ng-class="{etapaSeleccionada: tbl.faseActual.fas_id == fase.fas_id}">@{{ fase.fas_descripcion }}</button>
					</div>
				</div>
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
<script src="{!! asset('/assets/js/tablas/mostrar/factory.js') !!}"></script>
<script src="{!! asset('/assets/js/tablas/mostrar/controller.js') !!}"></script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-74410923-1', 'auto');
ga('send', 'pageview');

</script>

@endsection
