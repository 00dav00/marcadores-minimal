@extends('angular')

@section('content')

<div ng-app="wizardTorneo" ng-controller="wizardTorneoController as vm">

	<div class="col-xs-10 col-xs-offset-1">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title text-center">Wizard para configurar torneos</div>
			</div>

			<div class="panel-body">

				<div ng-switch="vm.paso" ng-init="vm.paso=1; vm.showTorneoInfo=false">

					{{-- seleccionar el torneo a configurar --}}
					<div class="row" ng-switch-when="1">
						
						<div class="form-group" >
							<label for="tor_id" class="control-label">Seleccionar Torneo</label>
							<select id="tor_id" name="tor_id" class="form-control" ng-model="vm.torneoSelected" ng-options="torneo.tor_nombre for torneo in vm.torneos" ng-change="vm.beginWizard()">
								<option value="" disabled>Torneo ...</option>
							</select>
						</div>

					</div>
					
					{{-- informacion de los equipos participantes --}}
					<div class="row" ng-if="vm.showTorneoInfo">
						
						<div class="well text-center">
							<h4><%vm.torneoSelected.tor_nombre%></h4>
							<p>Inicio: <%vm.torneoSelected.tor_fecha_inicio%></p>
							<p>Fin: <%vm.torneoSelected.tor_fecha_fin%></p>
							<p>Equipos Participantes: <%vm.torneoSelected.tor_numero_equipos%></p>
						</div>

						<alert ng-repeat="alert in vm.alerts" type="<%alert.type%>" close="vm.closeAlert($index)"><%alert.msg%></alert>

					</div>
					
					{{-- seleccion de equipos participantes --}}
					<div class="row" ng-switch-when="2">
						
						<div class="form-inline text-center">
							<div class="form-group">
								<label class="sr-only">Equipo</label>
								<p class="form-control-static">Equipos creados </p>
							</div>
							<div class="form-group">
								<select class="form-control" ng-model="vm.nuevoEquipo" ng-options="equipo.eqp_nombre for equipo in vm.equipos">
									<option value="" disabled>Equipos...</option>
								</select>
							</div>
							<button class="btn btn-default" ng-click="vm.agregarEquipo()">Agregar</button>
						</div>

						<br>

						<h3 class="text-center">Equipos Participantes</h3>

						<table class="table">
							<thead>
								<tr>
									<th>Número</th>
									<th>Equipo</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="equipoParticipante in vm.equiposParticipantes">
									<td><%$index + 1%></td>
									<td><%equipoParticipante.eqp_nombre%></td>
									<td>
										<button type="button" class="btn btn-danger btn-xs" aria-label="Left Align"><span class="glyphicon glyphicon-trash" aria-hidden="true" ng-click="vm.borrarEquipoParticipante(equipoParticipante)"></span></button>
									</td>
								</tr>
						</table>

						{{-- muestra los botones continuar o anterior --}}
						<div class="row">
						
							<div class="col-xs-4 col-xs-offset-8">
								<button class="btn btn-info" ng-disabled="vm.torneoSelected.tor_numero_equipos > vm.equiposParticipantes.length" ng-click="vm.fasesTorneo()">Siguiente <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
							</div>

						</div>

					</div>

					{{-- fases del torneo --}}
					<div class="row" ng-switch-when="3">

						<div class="panel panel-default">
							<div class="panel-body">

								<h5 class="text-center">Agregar una fase</h5>
						
								<form class="form-inline text-center" ng-submit="vm.crearFase()" name="agregarFase">
									<div class="form-group">
										<select class="form-control" ng-model="vm.nuevaFase.tfa_id" ng-options="tipoFase.tfa_id as tipoFase.tfa_nombre for tipoFase in vm.tiposFase" required>
											<option value="" disabled>Tipo de Fase...</option>
										</select>
									</div>
									<div class="form-group">
		    							<label class="sr-only" for="faseDescripcion">Descripción</label>
		    							<input type="text" class="form-control" ng-model="vm.nuevaFase.fas_descripcion" id="faseDescripcion" placeholder="Descripción" required>
									</div>
									<div class="form-group">
		    							<label class="sr-only" for="numeroFechas">Fechas</label>
		    							<input type="number" class="form-control" ng-model="vm.nuevaFase.num_fechas" id="numeroFechas" placeholder="Fechas" required>
									</div>
									<div class="checkbox">
		    							<label>
											<input type="checkbox" ng-model="vm.nuevaFase.fas_sumatoria" ng-true-value="1" ng-false-value="0"> Acumulada
		    							</label>
									</div>
									<input type="submit" class="btn btn-default" value="Agregar" ng-disabled="agregarFase.$invalid">
								</form>
						
							</div>
						</div>

						<br>

						<h3 class="text-center">Fases del Torneo</h3>

						<table class="table">
							<thead>
								<tr>
									<th>Número</th>
									<th>Fase</th>
									<th>Fechas</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="fase in vm.fases">
									<td><%$index + 1%></td>
									<td><%fase.fas_descripcion%></td>
									<td><%fase.fechas_conteo[0].contador%></td>
									<td>
										<button type="button" class="btn btn-danger btn-xs" aria-label="Left Align"><span class="glyphicon glyphicon-trash" aria-hidden="true" ng-click="vm.borrarFase($index)"></span></button>
									</td>
								</tr>
							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

	@endsection