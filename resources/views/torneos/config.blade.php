@extends('angular')

@section('content')

<div ng-app="wizardTorneo" ng-controller="wizardTorneoController as vm">

	<div class="col-xs-10 col-xs-offset-1">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title text-center">Wizard para configurar torneos</div>
			</div>

			<div class="panel-body">

				<div ng-switch="vm.paso" ng-init="vm.paso=1; vm.showTorneoInfo=false">

					{{-- seleccionar el torneo a configurar --}}
					<div class="row" ng-switch-when="1">
						
						<div class="form-group" >
							<label for="tor_id" class="control-label">Seleccionar Torneo</label>
							<select id="tor_id" name="tor_id" class="form-control" ng-model="vm.torneoSelected" ng-options="torneo.tor_nombre for torneo in vm.torneos" ng-change="vm.beginWizard()">
								<option value="" disabled>Torneo ...</option>
							</select>
						</div>

					</div>
					
					{{-- informacion de los equipos participantes --}}
					<div class="row" ng-if="vm.showTorneoInfo">
						
						<div class="well text-center">
							<h4><%vm.torneoSelected.tor_nombre%></h4>
							<p>Inicio: <%vm.torneoSelected.tor_fecha_inicio%></p>
							<p>Fin: <%vm.torneoSelected.tor_fecha_fin%></p>
							<p>Equipos Participantes: <%vm.torneoSelected.tor_numero_equipos%></p>
						</div>

						<alert ng-repeat="alert in vm.alerts" type="<%alert.type%>" close="vm.closeAlert($index)"><%alert.msg%></alert>

					</div>
					
					{{-- seleccion de equipos participantes --}}
					<div class="row" ng-switch-when="2">
						@include('torneos.partials.equiposParticipantes')
					</div>

					{{-- fases del torneo --}}
					<div class="row" ng-switch-when="3">
						@include('torneos.partials.fasesTorneo')
					</div>

					{{-- fechas de una fase --}}
					<div class="row" ng-switch-when="4">
						@include('torneos.partials.fechasFase')
					</div>

					{{-- partidos de una fecha --}}
					<div class="row" ng-switch-when="5">
						@include('torneos.partials.partidosFecha')
					</div>

				</div>

			</div>


		</div>

	</div>

</div>

@endsection

@section('scripts')
	<script src="{!! asset('/assets/js/vendor/jquery-ui.min.js') !!}"></script>
	<script src="{!! asset('/assets/js/vendor/angular-dragdrop.min.js') !!}"></script>

	<script src="{!! asset('/js/torneos/wizard/wizard.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.config.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.controller.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.factory.js') !!}"></script>
	<script src="{!! asset('/js/torneos/wizard/wizard.filter.js') !!}"></script>

@endsection
