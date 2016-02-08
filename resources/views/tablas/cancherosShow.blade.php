@extends('tablas')

@section('stylesheets')

<link href="{!! asset('/assets/css/cancheros/tablas/style.css') !!}" rel="stylesheet">

@endsection

@section('content')

<div ng-app="tablasTorneo" ng-controller="tablasController as tbl" ng-init="tbl.init({{$torneo}}, {{$cliente}})" class="container">
	<br>
	<header class="row titulo">
		<h3 class="text-center col-xs-6"><b>Primera A</b></h3>
		<h4 class="text-center col-xs-5"><button class="btn btn-default botones" ng-click="tbl.cambiarFasePosiciones(fase)"><b>@{{ tbl.faseActual.fas_descripcion }}</b></button></h4>
	</header>
	<br>

	<main>
		<section class="row posiciones">

			<table class="table">
				<tr class="header-tabla">
					<th class="col-xs-2 text-center">Pos</th>
					
					<th class="col-xs-6">Club</th>
					
					<th class="col-xs-2 text-center">PJ</th>
					
					<th class="col-xs-2 text-center">Pts</th>
				</tr>
				<tr ng-repeat="equipo in tbl.equipos">
					<td class="col-xs-2 text-center">@{{ $index + 1 }}</td>

					<td class="col-xs-6"><b>@{{ equipo.nombre_corto }}</b></td>
					
					<td class="col-xs-2 text-center">@{{ equipo.partidos_jugados }}</td>

					<td class="col-xs-2 text-center">@{{ equipo.puntos }}</td>

				</tr>
			</table>

		<div class="row text-center">
			<div class="btn-group btn-group-sm" role="group" ng-repeat="fase in tbl.fases">
				<button class="btn btn-default botones-fases" ng-click="tbl.cambiarFasePosiciones(fase)" ng-style="tbl.botonesStyle">@{{ fase.fas_descripcion }}</button>
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