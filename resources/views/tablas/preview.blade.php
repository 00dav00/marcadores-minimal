@extends('visual')

@section('content')

<div ng-app="tablasApp" ng-controller="TablasCtrl" data-ng-init="initPreview({!! $torneo_id !!})">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
			<div class="panel panel-default">

				<div class="panel-heading">Tabla de posiciones</div>

				<div class="form-group" ng-show="torneoSeleccionado">
					<small><label for="cbo_fases">Fases</label></small>
					<select id="cbo_fases" ng-model="faseSeleccionada" ng-change="obtenerTabla()" 
						ng-options="fase.fas_id as fase.fas_descripcion for fase in fases">
					</select>
				</div>

				<table class="table table-striped table-hover">
					<thead >
						<tr class="row">
							<td  class="col-xs-1 col-sm-1">&nbsp;</td>
							<td  class="col-xs-2 hidden-sm hidden-xs">Equipo</td>
							<td  class="col-sm-2 hidden-xs hidden-md hidden-lg">Equipo</td>
							<td  class="col-xs-2 hidden-sm hidden-md hidden-lg">Equipo</td>
							<td  class="col-xs-1 col-sm-1">PJ</td>
							<td  class="col-xs-1 col-sm-1">PG</td>
							<td  class="col-xs-1 col-sm-1">PE</td>
							<td  class="col-xs-1 col-sm-1">PP</td>
							<td  class="col-xs-1 col-sm-1 hidden-xs">GF</td>
							<td  class="col-xs-1 col-sm-1 hidden-xs">GC</td>
							<td  class="col-xs-1 col-sm-1">GD</td>
							<td  class="col-xs-1 col-sm-1">Pts</td>
						</tr>
					</thead>
					<tbody>
						<tr class="row" ng-repeat='equipo in tabla'>
							<td> <img class="imagenPromo" src="/<% equipo.escudo %>" style="max-width:15px;max-height:15px;"/> </td>
							<td  class="hidden-xs hidden-sm"><% equipo.nombre %></td>
							<td  class="hidden-xs hidden-md hidden-lg"><% equipo.nombre_corto %></td>
							<td  class="hidden-sm hidden-md hidden-lg"><% equipo.abreviatura %></td>
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

@endsection
