@extends('angular')

@section('content')

<div class="row centered-form" ng-app="plantillaApp" ng-controller="PlantillasCtrl">
	<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Configuración de Plantillas</h3>
			</div>
			<div class="panel-body">

				<div class="form-group" >
					<small><label for="tor_id">Seleccionar Torneo</label></small>
					<select id="tor_id" name="tor_id">
						<option value="">Torneo ...</option>
					</select>
				</div>

				<hr>

				<table width="100%">
					<tr class="text-center">
						<td class="col-md-2">
							<b ng-show="torneoSeleccionado">Equipos</b></td>
						<td class="col-md-1"></td>
						<td class="col-md-5">
							<b ng-show="equipoSeleccionado">Plantilla de: <% equipoSeleccionado.eqp_nombre %></b>
						</td>
					</tr>
					<tr>
						<td ng-show="torneoSeleccionado" valign="top">
							<table class="table table-striped" >
								<tr ng-repeat='equipo in equipos'>
									<td><% equipo.eqp_nombre %></td>
									<td>
										<button class="btn btn-primary btn-xs" ng-click="seleccionarEquipo($index)">
											<span class="glyphicon glyphicon-paste" ></span>
										</button>
									</td>
								</tr>
							</table>
						</td>
						<td></td>
						<td ng-show="equipoSeleccionado" valign="top">
							<div class="form-group">
								<hr>
								<table style="width: 100%;">
									<tr>
										<td style="width: 40%;"><label for="jug_id">Agregar jugador</label></td>
										<td style="padding-left: 2px;">
											<select id="jug_id" name="jug_id">
												<option value="">Jugador ...</option>
											</select>
										</td>
									</tr>
								</table>
							</div>
							<table class="table table-striped" >
								<thead>
									<tr>
										<td>
											<span class="glyphicon glyphicon-user"></span>
											&nbsp;&nbsp;&nbsp;Jugador
										</td>
										<td># Camiseta</td>
										<td>Acciones</td>
									<tr>
								<thead>
								<tbody>
									<tr ng-repeat='jugador in jugadores'>
										<td>
											<% jugador.jug_nombre + ' ' + jugador.jug_apellido %>
										</td>
										<td>
											<input type="number" ng-model="jugador.pivot.plt_numero_camiseta" min="1" max="200">											
										</td>
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
						</td>
					</tr>
				</table>
			</div>
			
		</div>
	</div>
</div>


<script>
$(function() {

	// TORNEOS

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
	    $(this).scope().obtenerEquipos($(this).val());
	});

	// JUGADORES

	$('#jug_id').selectize({
		valueField: 'jug_id',
		labelField: 'jug_apellido',
		searchField: ['jug_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.jug_nombre) + ' <strong>Apellido:</strong> ' + escape(item.jug_apellido) + ' <strong>Apodo:</strong> ' + escape(item.jug_apodo) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/jugadores/consulta',
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

	$('#jug_id').change(function () {
	    $(this).scope().ingresarJugadorEnPlantilla(
	    	$(this).val()
    	);
	});

});
</script>

@endsection