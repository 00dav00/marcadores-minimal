@extends('angular')

@section('content')

<div class="row centered-form" ng-app="plantillaApp" ng-controller="PlantillasCtrl">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Plantillas</h3>
			</div>
			<div class="panel-body">
				<div class="form-group" >
					<small><label for="tor_id">Seleccionar Torneo</label></small>
					<select id="tor_id" name="tor_id">
						<option value="">Torneo ...</option>
					</select>
				</div>

				<hr>
				<i  class="fa fa-spinner fa-spin"></i>

				<table width="100%">
					<tr align ="center">
						<td ng-show="torneoSeleccionado" width="35%">
							<b>Equipos</b>
						</td>
						<td>&nbsp;</td>
						<td ng-show="equipoSeleccionado" width="65%">
							<b>Plantilla de: <% equipoNombre %></b>
						</td>
					</tr>
					<tr>
						<td ng-show="torneoSeleccionado" valign="top">
							<table class="table table-striped" >
								<tr ng-repeat='equipo in equipos'>
									<td>
										<input name="eqp_id" type="hidden" value="<% equipo.eqp_id %>" />
										<% equipo.eqp_nombre %>
									</td>
									<td>
										<button id="btn_seleccionar_equipo" class="btn btn-primary btn-xs">  
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
											<input name="plt_id" type="hidden" value="<% jugador.pivot.plt_id %>" />
											<input name="jug_id" type="hidden" value="<% jugador.jug_id %>" />
											<% jugador.jug_nombre + ' ' + jugador.jug_apellido %>
										</td>
										<td>
											<input name="plt_numero_camiseta" type="text" ng-minlength="1" ng-maxlength="3" 
												size="3" value="<% jugador.pivot.plt_numero_camiseta %>">
											</input>
										</td>
										<td>
											<button id="btn_actualizar_jugador" class="btn btn-success btn-xs">  
												<span class="glyphicon glyphicon-floppy-save" ></span>
											</button>
											<button id="btn_borrar_jugador" class="btn btn-danger btn-xs">  
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

	// EQUIPOS

	$(document.body).on('click',"#btn_seleccionar_equipo",function(){
		$(this).scope().obtenerJugadores(
			$(this).closest('tr').find('input[name="eqp_id"]').val()
    	);
    	$(this).scope().colocarEquipoNombre(
    		$(this).closest('tr').find('td:first').text()
		);
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
	    	$('#tor_id').val(),
	    	$(this).scope().equipoSeleccionado,
	    	$(this).val()
    	);
	});

	$(document.body).on('click',"#btn_actualizar_jugador",function(){
		// alert($(this).closest('tr').find('input[name="plt_id"]').val());
		$(this).scope().actualizarJugadorEnPlantilla(
			$(this).closest('tr').find('input[name="plt_id"]').val(),
			$(this).closest('tr').find('input[name="jug_id"]').val(),
			$(this).closest('tr').find('input[name="plt_numero_camiseta"]').val()
    	);
	});

	$(document.body).on('click',"#btn_borrar_jugador",function(){
		// alert($(this).closest('tr').find('input[name="plt_numero_camiseta"]').val());
		$(this).scope().eliminarJugadorEnPlantilla(
			$(this).closest('tr').find('input[name="plt_id"]').val()
    	);
	});

});
</script>

@endsection