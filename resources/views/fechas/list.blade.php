@extends('angular')

@section('content')

<div class="row centered-form" ng-app="fechasApp" ng-controller="FechasCtrl" data-ng-init="initList()">
	<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
		<div class="panel panel-default">

			<h3 class="text-center">Fechas disponibles</h3>
			<br/>

			<div class="form-group" >
				<label for="tor_id" class="control-label">Seleccionar Torneo</label>
				<select id="tor_id" name="tor_id" class="form-control" ng-model="torneoSeleccionado" ng-change="obtenerFases()"
					ng-options="torneo.tor_nombre for torneo in torneos">
					<option value="" disabled>Torneo ...</option>
				</select>
			</div>

			<div class="form-group" ng-show="torneoSeleccionado">
				<label for="fas_id" class="control-label">Seleccionar Fase</label>
				<select id="fas_id" name="fas_id" class="form-control" ng-model="faseSeleccionada" ng-change="obtenerFechas()"
					ng-options="fase.fas_descripcion for fase in fases">
					<option value="" disabled>Fase ...</option>
				</select>
			</div>

			<div class="form-group" ng-show="faseSeleccionada">
				<table class="table table-striped table-hover">
					<thead>
						<td><b>Numero</b></td>
						<td><b>Estado</b></td>
						<td></td>
						<td></td>
					</thead>
					<tbody>
						<tr ng-repeat='fecha in fechas'>
							<td> <% fecha.fec_numero %> </td>
							<td> <% fecha.fec_estado %> </td>
							<td> 
								<button class="btn btn-info btn-xs" ng-click="irFechaTabla(fecha)">  
									<span class="glyphicon glyphicon-calendar" > Formato Tabla</span>
								</button>
						 	</td>
							<td> 
								<button class="btn btn-success btn-xs" ng-click="irFechaWidget(fecha)">  
									<span class="glyphicon glyphicon-tasks" > Formato Widget</span>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

@endsection