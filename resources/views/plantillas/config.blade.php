@extends('visual')

@section('content')

<div ng-app="plantillaApp" ng-controller="PlantillasCtrl">

	<div class="col-xs-10 col-xs-offset-1">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title text-center"><b>Wizard de configuración de Plantillas</b></div>
			</div>

			<div class="panel-body">

				{{-- informacion de los equipos participantes --}}
				<div class="row" ng-if="torneoSeleccionado">
					
					<div class="well text-center">
						<h4><% torneoSeleccionado.tor_nombre %></h4>
						<p>Inicio: <% torneoSeleccionado.tor_fecha_inicio %></p>
						<p>Fin: <% torneoSeleccionado.tor_fecha_fin %></p>
						<p>Equipos Participantes: <% torneoSeleccionado.tor_numero_equipos %></p>
					</div>					
				</div>

				{{-- informacion del equipo seleccionado --}}
				<div class="row" ng-if="equipoSeleccionado">
					<div class="well text-center"> <h4><% equipoSeleccionado.eqp_nombre %></h4> </div>					
				</div>

				<alert ng-repeat="alert in alerts" type="<%alert.type%>" dismiss-on-timeout="4000" close="closeAlert($index)"><%alert.msg%></alert>

				<div data-ng-switch="paso" ng-init="avanzarPaso()">

					{{-- seleccionar el torneo a configurar --}}
					<div class="row" ng-switch-when="1">
						
						<div class="form-group" >
							<label for="tor_id" class="control-label">Seleccionar Torneo</label>
							<select id="tor_id" name="tor_id" class="form-control" ng-model="$parent.torneoSeleccionado"
								ng-options="torneo as torneo.tor_nombre for torneo in torneos" ng-change="seleccionarTorneo()">
								<option value="" disabled>Torneo ...</option>
							</select>
						</div>
					</div>

					{{-- seleccion del equipo participante cuya plantilla va a ser modificada --}}
					<div class="row" ng-switch-when="2">
						@include('plantillas.partials.equiposParticipantes')
					</div>

					{{-- Plantilla del equipo seleccionado --}}
					<div class="row" data-ng-switch-when="3">
						@include('plantillas.partials.jugadoresInscritos')
					</div>

				</div>

			{{-- muestra los botones continuar o anterior --}}
			<div class="row text-center">
				<div style="width: 50%; float:left">
					<button class="btn btn-info" ng-click="volverPaso()" ng-disabled="!botonAnteriorActivado">
						<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Anterior
					</button>
				</div>
				<div style="width: 50%; float:right">
				   <button class="btn btn-info" ng-click="avanzarPaso()" ng-disabled="!botonSiguienteActivado">
						Siguiente <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
					</button>
				</div>
			</div>

				
			</div>
			
		</div>
	</div>
</duv>


@endsection