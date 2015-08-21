@extends('visual')

@section('content')

<div class="row centered-form" ng-app="tablasApp" ng-controller="TablasCtrl" data-ng-init="initPreview({!! $torneo_id !!})">
	<div class="col-xs-12 col-md-5">
		<div class="panel panel-default">

			<div class="panel-heading">Tablas de resultados</div>

			<div class="form-group" ng-show="torneoSeleccionado">
				<small><label for="cbo_fases">Fases</label></small>
				<select id="cbo_fases" ng-model="faseSeleccionada" ng-change="obtenerTabla()" 
					ng-options="fase.fas_id as fase.tipo_fase.tfa_nombre for fase in fases">
				</select>
			</div>

			<div class="form-group">
				<table class="table table-striped table-hover">
					<thead>
						<td  class="col-xs-1"></td>
						<td  class="col-xs-3">Equipo</td>
						<td  class="col-xs-1">PJ</td>
						<td  class="col-xs-1">PG</td>
						<td  class="col-xs-1">PE</td>
						<td  class="col-xs-1">PP</td>
						<td  class="col-xs-1">GF</td>
						<td  class="col-xs-1">GC</td>
						<td  class="col-xs-1">GD</td>
						<td  class="col-xs-1">Pts</td>
					</thead>
					<tbody>
						<tr ng-repeat='equipo in tabla'>
							<td> <img class="imagenPromo" src="/<% equipo.escudo %>" style="max-width:30px;max-height:30px;"/> </td>
							<td> <% equipo.nombre %> </td>
							<td> <% equipo.partidos_jugados %> </td>
							<td> <% equipo.partidos_ganados %> </td>
							<td> <% equipo.partidos_empatados %> </td>
							<td> <% equipo.partidos_perdidos %> </td>
							<td> <% equipo.goles_favor %> </td>
							<td> <% equipo.goles_contra %> </td>
							<td> <% equipo.goles_diferencia %> </td>
							<td> <b><% equipo.puntos %> </b></td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

@endsection