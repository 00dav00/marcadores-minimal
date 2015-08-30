<div class="panel panel-default">

	{{-- informacion de una fase seleccionada --}}
	<div class="panel-body text-center">
		<h4><%vm.faseSelected.fas_descripcion%></h4>
		<p>Tabla acumulada: <%vm.faseSelected.fas_acumulada | filtroCheckbox%></p>
		<p>Tipo de fase: <%vm.faseSelected.tipo_fase.tfa_nombre%></p>
	</div>

</div>

<h3 class="row text-center">Fechas</h3>

<div class="row text-center"><button class="btn btn-info" ng-click="vm.agregarFecha()">Agregar una fecha <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></div>

<table class="table">
	<thead>
		<tr>
			<th>Número</th>
			<th>Estado</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="fecha in vm.fechas">
			<td>Fecha <%$index + 1%></td>
			<td>
				<div class="btn-group">
			        <label ng-class="{jugada: selected}" class="btn btn-default" ng-change="vm.actualizarFecha(fecha)" ng-model="fecha.fec_estado" btn-radio="'jugada'">Jugada</label>
			        <label ng-class="{no_jugada: selected}" class="btn btn-default" ng-change="vm.actualizarFecha(fecha)" ng-model="fecha.fec_estado" btn-radio="'no_jugada'">No jugada</label>
			        <label ng-class="{en_juego: selected}" class="btn btn-default" ng-change="vm.actualizarFecha(fecha)" ng-model="fecha.fec_estado" btn-radio="'en_juego'">En juego</label>
			        <label ng-class="{suspendida: selected}" class="btn btn-default" ng-change="vm.actualizarFecha(fecha)" ng-model="fecha.fec_estado" btn-radio="'suspendida'">Suspendida</label>
			    </div>
			</td>

			<td>
				<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" ng-click="vm.editarFecha(fecha)">Ver <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
				<button type="button" class="btn btn-danger btn-xs" aria-label="Left Align" ng-click="vm.borrarFecha(fecha)">Borrar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
			</td>
		</tr>
	</table>

	{{-- muestra los botones continuar o anterior --}}
	<div class="row text-center">

		<div class="col-xs-4">
			<button class="btn btn-info" ng-click="vm.fasesTorneo()"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Anterior</button>
		</div>

	</div>

