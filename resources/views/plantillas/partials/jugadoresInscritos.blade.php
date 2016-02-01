<div class="form-group" >
	<label for="jug_id" >Agregar Jugador</label>
	<select id="jug_id" name="jug_id">
		<option value="" disabled>Jugador ...</option>
	</select>
</div>

<table class="table table-striped" >
	<thead>
		<tr>
			<td> <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;Jugador </td>
			<td># Camiseta</td>
			<td>Acciones</td>
		<tr>
	<thead>
	<tbody>
		<tr ng-repeat='jugador in jugadores'>
			<td><% jugador.jug_nombre + ' ' + jugador.jug_apellido %></td>
			<td><input type="number" ng-model="jugador.pivot.plt_numero_camiseta" min="1" max="200"></td>
			<td>
				<button class="btn btn-success btn-xs" ng-click="actualizarJugadorEnPlantilla($index)">  
					<span class="glyphicon glyphicon-floppy-save" ></span>
				</button>
				<button class="btn btn-danger btn-xs" ng-click="eliminarJugadorEnPlantilla($index)">  
					<span class="glyphicon glyphicon-trash" ></span>
				</button>
			</td>
		</tr>
	</tbody>
</table>

@include('partials.selectize', [
	'id' => '#jug_id', 'valueField' => 'jug_id', 'labelField' => 'jug_nombre', 'url' => '/api/jugadores/consulta', 
	'showFields' => ['Nombre' => 'jug_nombre', 'Apellido' => 'jug_apellido']
])

<script>
$(function() {

	$('#jug_id').change(function () {
	    $(this).scope().ingresarJugadorEnPlantilla($(this).val());
	});

});
</script>

