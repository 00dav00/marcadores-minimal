<h3 class="text-center">Fases del Torneo</h3>

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
					<input type="checkbox" ng-model="vm.nuevaFase.fas_acumulada" ng-true-value="1" ng-false-value="0"> Acumulada
				</label>
			</div>
			<input type="submit" class="btn btn-default" value="Agregar" ng-disabled="agregarFase.$invalid">
		</form>

	</div>
</div>

<table class="table">
	<thead>
		<tr>
			<th>Número</th>
			<th>Fase</th>
			<th>Acumulada</th>
			<th>Fechas</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="fase in vm.fases">
			<td><%$index + 1%></td>
			<td><%fase.fas_descripcion%></td>
			<td><%fase.fas_acumulada | filtroCheckbox%></td>
			<td><%fase.fechas_conteo[0].contador%></td>
			<td>
				<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" ng-click="vm.editarFase(fase)">Editar <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
				<button type="button" class="btn btn-danger btn-xs" aria-label="Left Align" ng-click="vm.borrarFase(fase)">Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</td>
		</tr>
	</table>

	<br>

	<h3 class="text-center">Penalizaciones</h3>

	<div class="panel panel-default">
	<div class="panel-body">

		<h5 class="text-center">Agregar una penalización</h5>

		<form class="form-inline text-center" ng-submit="vm.crearPenalizacion()" name="agregarPenalizacion">
			<div class="form-group">
				<select class="form-control" ng-model="vm.nuevaPenalizacion.fas_id" ng-options="fase.fas_id as fase.fas_descripcion for fase in vm.fases" required>
					<option value="" disabled>Fase...</option>
				</select>
			</div>
			<div class="form-group">
				<select class="form-control" ng-model="vm.nuevaPenalizacion.eqp_id" ng-options="equipo.eqp_id as equipo.eqp_nombre for equipo in vm.equiposParticipantes" required>
					<option value="" disabled>Equipo...</option>
				</select>
			</div>
			<div class="form-group">
				<label class="sr-only" for="penalizacionPuntos">Puntos</label>
				<input type="number" class="form-control" ng-model="vm.nuevaPenalizacion.ptr_puntos" id="penalizacionPuntos" placeholder="Puntos" required>
			</div>
			<div class="form-group">
				<label class="sr-only" for="penalizacionMotivo">Motivo</label>
				<input type="text" class="form-control" ng-model="vm.nuevaPenalizacion.ptr_motivo" id="penalizacionMotivo" placeholder="Motivo" required>
			</div>
			<input type="submit" class="btn btn-default" value="Agregar" ng-disabled="agregarPenalizacion.$invalid">
		</form>

	</div>
</div>

	<table class="table">
		<thead>
			<tr>
				<th>Fase</th>
				<th>Equipo</th>
				<th>Puntos</th>
				<th>Motivo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="penalizacion in vm.penalizaciones">
				<td><%penalizacion.fase.fas_descripcion%></td>
				<td><%penalizacion.equipo.eqp_nombre%></td>
				<td><%penalizacion.ptr_puntos%></td>
				<td><%penalizacion.ptr_motivo%></td>
				<td>
					<button type="button" class="btn btn-danger btn-xs" aria-label="Left Align" ng-click="vm.borrarPenalizacion(penalizacion)">Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
				</td>
			</tr>
		</table>