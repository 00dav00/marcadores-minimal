@extends('tablas')

@section('stylesheets')

<link href="{!! asset('/assets/css/tablas/style.css') !!}" rel="stylesheet">

@endsection

@section('content')

<div ng-app="tablasTorneo" ng-controller="tablasController as tbl" ng-init="tbl.init({{$torneo}}, {{$cliente}})" class="container" ng-style="tbl.containerStyle">

	<br>
	<header class="row titulo" ng-style="tbl.headerStyle">
		<h3 class="text-center col-xs-14 col-xs-offset-2">@{{ tbl.torneo.tor_nombre }}</h3>
		<h4 class="text-center col-xs-14 col-xs-offset-2">@{{ tbl.faseActual.fas_descripcion }}</h4>
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

		<div class="row text-center">
			<div class="btn-group btn-group-sm" role="group" ng-repeat="fase in tbl.fases">
				<button class="btn btn-default botones" ng-click="tbl.cambiarFasePosiciones(fase)" ng-style="tbl.botonesStyle">@{{ fase.fas_descripcion }}</button>
			</div>
		</div>
		</section>

		<br>

		<footer class="row">
			<p class="text-center"><img src="/images/dataprensa.png" alt="DataPrensa logo"></p>
		</footer>

	</main>
</div>

	@endsection

	@section('scripts')

	<script src="{!! asset('/assets/js/tablas/mostrar/app.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/exception.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/factory.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/controller.js') !!}"></script>

	@endsection
