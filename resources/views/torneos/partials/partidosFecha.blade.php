<style>
.thumbnail { height: 60px !important; }
.btn-droppable { width: 210px; height: 30px; padding: 4px; margin: 4px;}
.btn-draggable { width: 200px; }
</style>

<div class="panel panel-default">

	{{-- informacion de una fase seleccionada --}}
	<div class="panel-body text-center">
		<h4><%vm.faseSelected.fas_descripcion%></h4>
		<p>Fecha: <%vm.fechaSelected.fec_numero%></p>
	</div>

</div>

<h3 class="row text-center">Partidos de la fecha</h3>

<div class="row text-center"><button class="btn btn-default" ng-click="vm.showAgregarPartido()">Agregar un partido <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></div>

<br>

<div ng-show="vm.mostrarAgregarPartido" ng-init="vm.mostrarAgregarPartido = false">
	<div class="row">

		<h4 class="text-center">Agregar un partido</h4>

		<div class="col-xs-4 col-xs-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Equipos participantes</h3>
				</div>
				<div class="panel-body">
					<div class="btn btn-droppable" ng-repeat="equipo in vm.equiposSeleccionables" data-drop="true" ng-model='vm.equiposSeleccionables' data-jqyoui-options="{accept:'.btn-draggable:not([ng-model=vm.equiposSeleccionables])'}"  jqyoui-droppable="{index: <%$index%>}">
						<div class="btn btn-info btn-draggable" data-drag="true" data-jqyoui-options="{revert: 'invalid'}" ng-model="vm.equiposSeleccionables" jqyoui-draggable="{index: <%$index%>,placeholder:true,animate:true}" ng-hide="!equipo.eqp_nombre"><%equipo.eqp_nombre%></div>
					</div>
				</div>
			</div>

		</div>

		<div class="col-xs-5 col-xs-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Partido</h3>
				</div>
				<div class="panel-body">

					<div class="form-group">
						<label>Equipo local</label>
						<div class="thumbnail" data-drop="true" ng-model='vm.nuevoPartido.equipoLocal' data-jqyoui-options="vm.optionsEquipoLocal" jqyoui-droppable="{multiple:true}">
							<div class="caption">
								<div class="btn btn-success btn-draggable" ng-repeat="equipo in vm.nuevoPartido.equipoLocal" ng-show="equipo.eqp_nombre" data-drag="true" data-jqyoui-options="{revert: 'invalid'}" ng-model="vm.nuevoPartido.equipoLocal" jqyoui-draggable="{index: <%$index%>,animate:true}"><%equipo.eqp_nombre%></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Equipo Visitante</label>
						<div class="thumbnail" data-drop="true" ng-model='vm.nuevoPartido.equipoVisitante' data-jqyoui-options="vm.optionsEquipoVisitante" jqyoui-droppable="{multiple:true}">
							<div class="caption">
								<div class="btn btn-warning btn-draggable" ng-repeat="equipo in vm.nuevoPartido.equipoVisitante" ng-show="equipo.eqp_nombre" data-drag="true" data-jqyoui-options="{revert: 'invalid'}" ng-model="vm.nuevoPartido.equipoVisitante" jqyoui-draggable="{index: <%$index%>,animate:true}"><%equipo.eqp_nombre%></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Estadio</label>
						<div class="form-group">
							<select class="form-control" ng-model="vm.nuevoPartido.est_id" ng-options="estadio.est_id as estadio.est_nombre for estadio in vm.estadios" required>
								<option value="" disabled>Estadio...</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label>Fecha</label>
						<p class="input-group">
							<input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="vm.nuevoPartido.par_fecha" is-open="vm.status.opened" datepicker-options="vm.dateOptions" ng-required="true" close-text="Cerrar" />
							<span class="input-group-btn">
								<button type="button" class="btn btn-default" ng-click="vm.open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
							</span>
						</p>
					</div>

					<div class="form-group">
						<label>Hora</label>
						<timepicker ng-model="vm.nuevoPartido.par_hora" hour-step="1" minute-step="1" show-meridian="false"></timepicker>
					</div>

					<div class="form-group">
						<button class="btn btn-default form-control" ng-click="vm.agregarPartido()">Crear partido</button>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Lista de partidos</h3>
	</div>
	<div class="text-center">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Local</th>
					<th>Visitante</th>
					<th>Estadio</th>
					<th>Fecha</th>
					<th>Hora</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="partido in vm.partidos">
					<td><%$index + 1%></td>
					<td><%partido.equipo_local.eqp_nombre%></td>
					<td><%partido.equipo_visitante.eqp_nombre%></td>
					<td><%partido.estadio.est_nombre%></td>
					<td><%partido.par_fecha%></td>
					<td><%partido.par_hora%></td>
					<td>
						
						<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" ng-click="vm.editarPartido(partido)">Editar <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>

						<button type="button" class="btn btn-danger btn-xs" aria-label="Left Align" ng-click="vm.borrarPartido(partido)">Borrar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>

					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
{{-- muestra los botones continuar o anterior --}}
<div class="row text-center">

	<div class="col-xs-4">
		<button class="btn btn-info" ng-click="vm.regresarFechasFase()"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Anterior</button>
	</div>

</div>


<script type="text/ng-template" id="editarPartido.html">
	<div class="modal-header">
		<h3 class="modal-title">Editar Partido</h3>
	</div>
	<div class="modal-body">

		<div class="form-group">
			<label for="equipoLocal">Equipo local</label>
			<input type="text" class="form-control" id="equipoLocal" value="<%md.partido.equipo_local.eqp_nombre%>" disabled>
		</div>
		<div class="form-group">
			<label for="golesLocal">Goles local</label>
			<input type="number" class="form-control" id="golesLocal" ng-model="md.partido.par_goles_local">
		</div>
		<div class="form-group">
			<label for="equipoVisitante">Equipo local</label>
			<input type="text" class="form-control" id="equipoVisitante" value="<%md.partido.equipo_visitante.eqp_nombre%>" disabled>
		</div>
		<div class="form-group">
			<label for="golesVisitante">Goles visitante</label>
			<input type="number" class="form-control" id="golesVisitante" ng-model="md.partido.par_goles_visitante">
		</div>
		<div class="form-group">
			<label>Estadio</label>
			<div class="form-group">
				<select class="form-control" ng-model="md.partido.est_id" ng-options="estadio.est_id as estadio.est_nombre for estadio in md.estadios" required>
					<option value="" disabled>Estadio...</option>
				</select>
			</div>
		</div>
		<div class="checkbox">
    		<label>
    			<input type="checkbox" ng-model="md.partidoDiferido" ng-true-value=true ng-false-value=false> Partido diferido
    		</label>
		</div>
		<div ng-hide="md.partidoDiferido">
			<div class="form-group">
				<label>Fecha</label>
				<p class="input-group">
					<input type="text" class="form-control" datepicker-popup="yyyy-MM-dd" ng-model="md.partido.par_fecha" is-open="md.status.opened" datepicker-options="md.dateOptions" ng-required="true" close-text="Cerrar" />
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" ng-click="md.open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
					</span>
				</p>
			</div>
			<div class="form-group">
				<label>Hora</label>
				<timepicker ng-model="md.partido.par_hora" hour-step="1" minute-step="1" show-meridian="false"></timepicker>
			</div>
		</div>

	</div>
	<div class="modal-footer">
		<button class="btn btn-warning" type="button" ng-click="md.editar()">Editar</button>
		<button class="btn btn-default" type="button" ng-click="md.cancel()">Cancel</button>
	</div>
</script>
