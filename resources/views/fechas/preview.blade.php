@extends('visual')

@section('content')

<div class="row centered-form" ng-app="fechasApp" ng-controller="FechasCtrl" data-ng-init="initPreview({!! $fecha_id !!})">
	<div class="col-xs-12 col-md-5">
		<div class="panel panel-default">

			<div class="panel-heading">
				<b><% faseSeleccionada.torneo.tor_nombre %> </b><br/>
				<% faseSeleccionada.tipo_fase.tfa_nombre %>, Fecha <% fechaSeleccionada.fec_numero %> 
			</div>

			<br/>

			<div class="form-group">
				<table class="table table-striped table-hover">
					<thead>
						<td colspan="3" class="col-xs-2 text-center"><b>LOCAL</b></td>
						<td class="col-xs-1">&nbsp;&nbsp;&nbsp;</td>
						<td colspan="3" class="col-xs-2 text-center"><b>VISITANTE</b></td>
					</thead>
					<tbody>
						<tr ng-repeat='partido in partidos'>
							<td> <img src="/<% partido.equipo_local.eqp_escudo %>" style="max-width:30px;max-height:30px;"/> </td>
							<td> <% partido.equipo_local.eqp_nombre %> </td>
							<td> <% partido.par_goles_local %> </td>
							<td> <b>VS</b> </td>
							<td> <% partido.par_goles_visitante %> </td>
							<td> <% partido.equipo_visitante.eqp_nombre %> </td>
							<td> <img src="/<% partido.equipo_visitante.eqp_escudo %>" style="max-width:30px;max-height:30px;"/> </td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

@endsection