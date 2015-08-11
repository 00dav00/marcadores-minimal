@extends('angular')

@section('content')

<div class="row centered-form" ng-app="tablasApp" ng-controller="TablasCtrl">
	<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
		<div class="panel panel-default">

			<div class="panel-heading">Tablas de resultados</div>

			<div class="form-group" >
				<small><label for="tor_id">Seleccionar Torneo</label></small>
				<select id="tor_id" name="tor_id">
					<option value="">Torneo ...</option>
				</select>
			</div>

			<div class="form-group" ng-show="torneoSeleccionado">
				<small><label for="cbo_fases">Fases</label></small>
				<select id="cbo_fases" ng-model="faseSeleccionada" ng-change="obtenerTabla()" 
					ng-options="fase.fas_id as fase.tipo_fase.tfa_nombre for fase in fases">
					<option value="" disabled>Elegir Fase ...</option>
				</select>
			</div>

			<div class="form-group" ng-show="faseSeleccionada">
				<table class="table table-striped table-hover">
					<thead>
						<td>#</td>
						<td>Nombre</td>
						<td>Puntos</td>
						<td>Jugados</td>
						<td>Ganados</td>
						<td>Empatados</td>
						<td>Perdidos</td>
						<td>A favor</td>
						<td>En contra</td>
						<td>Diferencia</td>
					</thead>
					<tbody>
						<tr ng-repeat='equipo in tabla'>
							<td> <% $index + 1%> </td>
							<td> <% equipo.nombre %> </td>
							<td> <% equipo.puntos %> </td>
							<td> <% equipo.partidos_jugados %> </td>
							<td> <% equipo.partidos_ganados %> </td>
							<td> <% equipo.partidos_empatados %> </td>
							<td> <% equipo.partidos_perdidos %> </td>
							<td> <% equipo.goles_favor %> </td>
							<td> <% equipo.goles_contra %> </td>
							<td> <% equipo.goles_diferencia %> </td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
$(function() {

	$('#tor_id').selectize({
		valueField: 'tor_id',
		labelField: 'tor_nombre',
		searchField: ['tor_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.tor_nombre) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/torneos/consulta',
				type: 'GET',
				dataType: 'json',
				data: {
					nombre: query
				},
				success: function(res) {
					callback(res.data);
				}
			});
		}
	});

	$('#tor_id').change(function () {
	    $(this).scope().definirTorneo($(this).val());
	});
});

</script>

@endsection