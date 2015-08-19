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
				<button type="button" class="btn btn-danger btn-xs" aria-label="Left Align" ng-click="vm.borrarEquipoParticipante(equipoParticipante)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</td>
		</tr>
	</table>

	{{-- muestra los botones continuar o anterior --}}
	<div class="row">

		<div class="col-xs-4 col-xs-offset-8">
			<button class="btn btn-info" ng-disabled="vm.torneoSelected.tor_numero_equipos > vm.equiposParticipantes.length" ng-click="vm.fasesTorneo()">Siguiente <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
		</div>

	</div>