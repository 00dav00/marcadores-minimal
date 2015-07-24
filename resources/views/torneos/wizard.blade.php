@extends('angular')

@section('content')

<div class="row centered-form" ng-app="torneoApp" ng-controller="TorneoCtrl">
	<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title"><b>Asistente de configuración de Torneo</b></h3>
				<h3 class="panel-title" ng-show="torneoSeleccionado">
					<br/><b>Torneo:</b> <% torneoSeleccionado.tor_nombre%>
					&nbsp;(<% torneoSeleccionado.tipo_torneo.ttr_nombre%>) 
					<br/><b>Desde:</b> <% torneoSeleccionado.tor_fecha_inicio%>
					<b>Hasta:</b> <% torneoSeleccionado.tor_fecha_fin%>
					<br/><b>Num. Equipos:</b> <% torneoSeleccionado.tor_numero_equipos%>
				</h3>

				<h3 class="panel-title" ng-show="faseSeleccionada">
					<br/><b>Tipo de Fase:</b> <% faseSeleccionada.tipo_fase.tfa_nombre %>
					<br/><b>Descripción:</b> <% faseSeleccionada.fas_descripcion %>
					<br/><b>Num. Fechas:</b> <% faseSeleccionada.fechas_conteo[0].contador %>
				</h3>
			</div>

			<div ng-show="mostrarPaso(1)">
				<div class="form-group" >
					<small><label for="tor_id">Seleccionar Torneo</label></small>
					<select id="tor_id" name="tor_id">
						<option value="">Torneo ...</option>
					</select>
				</div>
			</div>


			<div ng-show="mostrarPaso(2)">
				<div ng-hide="equiposCompletos()">
					<span>Agregar Equipo: </span>
					<span>
						<select id="eqp_id" name="eqp_id">
							<option value="">Equipo ...</option>
						</select>
					</span>
				</div>
				<hr/>
				<div class="alert alert-info" role="alert" ng-show="equiposCompletos()">
					Cuota de equipos para el torneo completa.
				</div>
				<table id="tbl_equipos" class="table table-striped" >
					<thead>
						<tr>
							<td><b>Equipos inscritos</b></td>
							<td></td>
						<tr>
					<thead>
					<tbody>
						<tr ng-repeat='equipo in equipos'>
							<td>
								<input name="eqp_id" type="hidden" value="<% equipo.eqp_id %>" />
								<% equipo.eqp_nombre %>
							</td>
							<td>
								<button id="btn_borrar_equipo" class="btn btn-danger btn-xs" ng-click="eliminarEquipoInscrito($index)">  
									<span class="glyphicon glyphicon-trash" ></span>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>


			<div ng-show="mostrarPaso(3)">
				
				<div align="center"><b>Crear Fase para el presente Torneo</b></div>
				<br>
				<div>
					<alert ng-repeat="error in erroresFase" type="danger" close="closeAlert($index)"><% error %></alert>
				</div>
				<div class="form-group">
					<small><label for="cbo_tipo_fase">Tipo de Fase</label></small>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<select id="cbo_tipo_fase" ng-model="tipoFaseSeleccionado" ng-options="tipoFase.tfa_id as tipoFase.tfa_nombre for tipoFase in tiposFase">
					    <option value="">Seleccionar</option>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<button id="btn_ingresar_tipo_fase" class="btn btn-info btn-xs" ng-click="showModal()">  
						<span class="glyphicon glyphicon-flash">Nuevo Tipo</span>
					</button>
				</div>
				<div class="form-group">
					<small><label for="txt_fase_descripcion">Descripción</label></small>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="txt_fase_descripcion" type="text" size="50" placeholder="descripción...">
				</div>
				<div>
					<small><label for="num_fechas">Número de Fechas</label></small>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input id="num_fechas" type="number" ng-model="numeroFechas" min="1" max="100">
				</div>
				<div align="center">
					<button class="btn btn-info btn-xs" ng-click="ingresarFase()">  
						<span class="glyphicon glyphicon-save">&nbsp;&nbsp;Crear Fase</span>
					</button>
				</div>
				<hr>

				<div align="center"><b>Elija la fase que desea modificar</b></div>
				<div>
					<table id="tbl_fases" class="table table-striped table-hover" >
						<thead>
							<tr>
								<td><b>Fases</b></td>
								<td><b>Fechas</b></td>
								<td></td>
							<tr>
						<thead>
						<tbody>
							<tr class="fase_fila" ng-repeat='fase in fases' 
								ng-class="{'selected':$index == faseSeleccionadaFila}" ng-click="seleccionarFase($index)">
								<td>
									<input name="fas_id" type="hidden" value="<% fase.fas_id %>" />
									<% fase.tipo_fase.tfa_nombre %>
								</td>
								<td>
									<% fase.fechas_conteo[0].contador %>
								</td>
								<td>
									<button id="btn_borrar_fase" class="btn btn-danger btn-xs" ng-click="eliminarFase($index)"> 
										<span class="glyphicon glyphicon-trash" ></span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>


			<div ng-show="mostrarPaso(4)">
				<div class="text-center"><b>Crear Fecha para la presente Fase</b></div>
				<br>
				<div>
					<alert ng-repeat="error in erroresFecha" type="danger" close="closeAlert($index)"><% error %></alert>
					<br>
				</div>				
				<div class="form-group form-inline">
					<label for="txt_fecha_ref" class="col-xs-2">Fecha de Referencia</label>					
              		<input id="txt_fecha_ref" class="col-xs-6 form-control" type="text" 
              			datepicker-popup="yyyy-MM-dd" min-date="'2010-06-22'" max-date="'2020-06-22'"
              			ng-model="fechaCalendario.valor" is-open="fechaCalendario.abierto" 
              			ui-date="{dateFormat: 'yyyy-mm-dd'}" ui-date-format="yyyy-mm-dd" close-text="Cerrar" />
          			<button type="button" class="btn btn-info btn-default" ng-click="abrirCalendarioFecha($event)">  
						<span class="glyphicon glyphicon-calendar"></span>
					</button>
		        </div>
				<div class="text-center">
					<button class="btn btn-info btn-xs" ng-click="ingresarFecha()">  
						<span class="glyphicon glyphicon-save">&nbsp;&nbsp;Crear Fecha</span>
					</button>
				</div>
				<hr>

				<div class="text-center"><b>Listado de fechas</b></div>
				<table id="tbl_fechas" class="table table-striped" >
					<thead>
						<tr>
							<td class="col-xs-1"><b>#Num</b></td>
							<td class="col-xs-5"><b>Fecha de Referencia</b></td>
							<td class="col-xs-4"><b>Partidos</b></td>
							<td class="col-xs-2"></td>
						<tr>
					<thead>
					<tbody>
						<tr ng-repeat='fecha in fechas'>
							<td>
								<input name="fec_id" type="hidden" value="<% fecha.fec_id %>" />
								<% fecha.fec_numero %>
							</td>
							<td class="form-group form-inline">
								<input class="form-control" type="text" datepicker-popup="yyyy-MM-dd" 
			              			ng-model="fechas[$index].fec_fecha_referencia" is-open="fechas[$index].calendarioAbierto" 
									min-date="'2010-06-22'" max-date="'2020-06-22'" close-text="Cerrar" 
									ui-date-format="yyyy-MM-dd" ui-date="{dateFormat: 'yyyy-MM-dd'}"/>
			          			<button type="button" class="btn btn-info btn-default" ng-click="abrirCalendarioListaFechas($event,$index)">
									<span class="glyphicon glyphicon-calendar"></span>
								</button>
							</td>
							<td>
								<% fecha.partidos_conteo[0].contador %>
							</td>
							<td class="form-group form-inline">
								<button class="btn btn-primary btn-xs" ng-click="actualizarFecha($index)"> 
									<span class="glyphicon glyphicon-floppy-save" ></span>
								</button>
								<button class="btn btn-danger btn-xs" ng-click="eliminarFecha($index)"> 
									<span class="glyphicon glyphicon-trash" ></span>
								</button>
								
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div ng-show="mostrarPaso(5)">
				<br><br><br><br><br>
				<h1 class="text-center">Wizard Finalizado</h1>
				<br><br><br><br><br>
			</div>

			<div ng-show="torneoSeleccionado">
				<table style="width:100%;">
					<tr>
						<td style="width:50%;" align="center">
							<button id="btn_anterior" class="btn btn-primary btn-xs" ng-click="anteriorPaso()"
									ng-disabled="dehabilitarAnterior()">
								<span class="glyphicon glyphicon-hand-left">&nbsp;Anterior</span>
							</button>
						</td>
						<td style="width:50%;" align="center">
							<button id="btn_siguiente" class="btn btn-primary btn-xs"
								ng-disabled="dehabilitarSiguiente()">
								Siguiente&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-hand-right"></span>
							</button>
						</td>
					</tr>
				</table>
			</div>


			<div class="panel-heading" align="right">
				<h4 class="panel-title"><b>[Paso:<% obtenerAvanceWizard() %>]</b><h4>
			</div>
		</div>

	</div>
</div>

<style>
	.selected {
    	text-decoration: underline;
	    font-weight:bold;
	}
</style>

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
	    $(this).scope().colocarTorneo($(this).val());
	});

	// EQUIPOS

	$('#eqp_id').selectize({
		valueField: 'eqp_id',
		labelField: 'eqp_nombre',
		searchField: ['eqp_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.eqp_nombre) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/equipos/consulta',
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

	$('#eqp_id').change(function () {
	    $(this).scope().inscribirEquipo($(this).val());
	});

	// $(document.body).on('click',"#btn_borrar_equipo",function(){
	// 	$(this).scope().eliminarEquipoInscrito(
	// 		$(this).closest('tr').find('input[name="eqp_id"]').val()
 //    	);
	// });

	// CONTROLES

	$('#btn_siguiente').click(function() {
		var data;
	    $(this).scope().siguientePaso(data);
	});

	$(document.body).on('mouseenter','.fase_fila',function(){
		$(this).css('color', 'red');
	});
	$(document.body).on('mouseleave','.fase_fila',function(){
		$(this).css('color', 'black');
	});
	
});
</script>

@endsection