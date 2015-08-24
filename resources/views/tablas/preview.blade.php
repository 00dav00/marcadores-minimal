@extends('visual')

@section('content')

<div ng-app="tablasApp" ng-controller="TablasCtrl" data-ng-init="initPreview({!! $torneo_id !!})">

	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">

				<div class="panel-heading">Tablas de resultados</div>

				<div class="form-group" ng-show="torneoSeleccionado">
					<small><label for="cbo_fases">Fases</label></small>
					<select id="cbo_fases" ng-model="faseSeleccionada" ng-change="obtenerTabla()" 
					ng-options="fase.fas_id as fase.fas_descripcion for fase in fases">
				</select>
			</div>

			<div class="row">
				<div class="col-xs-10">
					<table class="table table-striped table-hover">
						<thead>
							<td  class="col-xs-1"></td>
							<td  class="col-xs-3 hidden-xs">Equipo</td>
							<td  class="col-xs-3">Equipo</td>
							<!-- <td  class="col-xs-3">Equipo</td> -->
							<td  class="col-xs-1">PJ</td>
							<td  class="col-xs-1">PG</td>
							<td  class="col-xs-1">PE</td>
							<td  class="col-xs-1">PP</td>
							<td  class="col-xs-1 hidden-xs">GF</td>
							<td  class="col-xs-1 hidden-xs">GC</td>
							<td  class="col-xs-1">GD</td>
							<td  class="col-xs-1">Pts</td>
						</thead>
						<tbody>
							<tr ng-repeat='equipo in tabla'>
								<td> <img class="imagenPromo" src="/<% equipo.escudo %>" style="max-width:22px;max-height:26px;"/> </td>
								<td class="hidden-xs"> <% equipo.nombre %> </td>
								<td> <% equipo.nombre_corto %> </td>
								<!-- <td> <% equipo.abreviatura %> </td> -->
								<td> <% equipo.partidos_jugados %> </td>
								<td> <% equipo.partidos_ganados %> </td>
								<td> <% equipo.partidos_empatados %> </td>
								<td> <% equipo.partidos_perdidos %> </td>
								<td class="hidden-xs"> <% equipo.goles_favor %> </td>
								<td class="hidden-xs"> <% equipo.goles_contra %> </td>
								<td> <% equipo.goles_diferencia %> </td>
								<td> <b><% equipo.puntos %> </b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

@endsection