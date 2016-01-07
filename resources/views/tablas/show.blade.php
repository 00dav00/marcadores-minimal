@extends('tablas')

@section('content')

<div ng-app="tablasTorneo" ng-controller="tablasController as tbl" ng-init="tbl.init({{$torneo}}, {{$cliente}})">

	<span us-spinner="{lines:15, radius:15, width:5, length: 10, position:absolute, top:'50%', left:'50%'}" spinner-key="spinner-1"></span>

	<header>
		<h1>@{{ tbl.torneo.tor_nombre }}</h1>
	</header>
	<main>
		<section>
			<select ng-model="tbl.faseActual" ng-options="fase.fas_id as fase.fas_descripcion for fase in tbl.fases" ng-change="tbl.mostrarFasePosiciones()"></select>
		</section>
		<section>
			<table>
				<tr>
					<th>Posición</th>
					<th>Escudo</th>
					<th>Equipo</th>
					<th>PJ</th>
					<th>PG</th>
					<th>PE</th>
					<th>PP</th>
					<th>GF</th>
					<th>GC</th>
					<th>GD</th>
					<th>Pts</th>
				</tr>
				<tr ng-repeat="equipo in tbl.equipos">
					<td>@{{ $index + 1 }}</td>
					<td><img ng-src="/@{{ equipo.escudo }}" alt="@{{ equipo.abreviatura }}" style="max-width:15px;max-height:15px;"/></td>
					<td>@{{ equipo.nombre }}</td>
					<td>@{{ equipo.partidos_jugados }}</td>
					<td>@{{ equipo.partidos_ganados }}</td>
					<td>@{{ equipo.partidos_empatados }}</td>
					<td>@{{ equipo.partidos_perdidos }}</td>
					<td>@{{ equipo.goles_favor }}</td>
					<td>@{{ equipo.goles_contra }}</td>
					<td>@{{ equipo.goles_diferencia }}</td>
					<td>@{{ equipo.puntos }}</td>
				</tr>
			</table>
		</section>
		<footer>
			<p>&copy; 2016 Dataprensa</p>
		</footer>
	</main>

	@endsection

	@section('scripts')

	<script src="{!! asset('/assets/js/tablas/mostrar/app.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/exception.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/factory.js') !!}"></script>
	<script src="{!! asset('/assets/js/tablas/mostrar/controller.js') !!}"></script>

	@endsection