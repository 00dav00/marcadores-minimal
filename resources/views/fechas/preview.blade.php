@extends('visual')

@section('content')

<div class="row centered-form" ng-app="fechasApp" ng-controller="FechasCtrl" data-ng-init="initPreview({!! $fecha_id !!},{!! $fase_id !!})">
	<div class="col-xs-12 col-md-5">
		<div class="panel panel-default">

			<div class="panel-heading">
				<b><% faseSeleccionada.torneo.tor_nombre %> </b><br/>
				<% faseSeleccionada.fas_descripcion %>, Fecha <% fechaSeleccionada.fec_numero %>
			</div>

			<br/>

			<div class="form-group">
				<table class="table table-striped table-hover table-condensed">
					<thead>
						<tr class="row">
							<td class="col-xs-5 text-center" colspan="3" ><b>LOCAL</b></td>
							<td class="col-xs-2 text-center">&nbsp;&nbsp;&nbsp;</td>
							<td class="col-xs-5 text-center" colspan="3" ><b>VISITANTE</b></td>
						</tr>
					</thead>
					<tbody>
						<tr class="row" ng-repeat='partido in partidos'>
							<td class="text-left" > <img src="/<% partido.equipo_local.eqp_escudo %>" style="max-width:22px;max-height:26px;"/> </td>
							<td class="text-left"> <% partido.equipo_local.eqp_nombre_corto %> </td>
							<td class="text-left"> <% partido.par_goles_local %> </td>
							<td class="text-center"> <b><% partido.separador %></b> </td>
							<td class="text-right"> <% partido.par_goles_visitante %> </td>
							<td class="text-right"> <% partido.equipo_visitante.eqp_nombre_corto %> </td>
							<td class="text-right"> <img src="/<% partido.equipo_visitante.eqp_escudo %>" style="max-width:22px;max-height:26px;"/> </td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="text-right panel-heading">
				<button class="btn btn-success btn-xs btn-sm"  ng-disabled="!existeFechaAnterior" ng-click="irFechaAnterior(irFechaTabla)">  
					<span class="glyphicon glyphicon-chevron-left" > Anterior</span>
				</button>
				
				<button class="btn btn-success btn-xs btn-sm" ng-disabled="!existeFechaSiguiente" ng-click="irFechaSiguiente(irFechaTabla)">  
					Siguiente<span class="glyphicon glyphicon-chevron-right" ></span>
				</button>
			</div>

		</div>
	</div>
</div>

@endsection