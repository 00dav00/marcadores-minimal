@extends('tablas')

@section('stylesheets')

<link href="{!! asset('/assets/css/tablas/style.css') !!}" rel="stylesheet">

@endsection

@section('content')

<div ng-app="tablasTorneo" ng-controller="tablasController as tbl" ng-init="tbl.init({{$torneo}}, {{$cliente}})" class="container">

	<br>
	<header class="row header">
		<h4 class="text-center col-xs-14 col-xs-offset-2">@{{ tbl.torneo.tor_nombre }}</h4>
		<p class="text-center col-xs-14 col-xs-offset-2 btn btn-default">@{{ tbl.faseActual.fas_descripcion }}</p>
	</header>
	
	<br>

	<main>
		<section class="row posiciones">

			<table class="table table-hover">
				<tr>
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
			
		</section>

		<div class="row container-fluid">
			<div class="col-xs-1 col-sm-1"></div>
			<div class="text-center col-xs-4 col-sm-4" ng-repeat="fase in tbl.fases"><a href="#" ng-click="tbl.cambiarFasePosiciones(fase)">@{{ fase.fas_descripcion }}</a></div>
		</div>
		<br>

		<footer class="row">
			<p class="text-center"><img src="/images/dataprensa.png" alt="DataPrensa logo"></p>
		</footer>

	</main>

	@endsection

	@section('scripts')

	<script src="{!! asset('/assets/js/tablas/mostrar/app.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/exception.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/factory.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/controller.js') !!}"></script>

	@endsection