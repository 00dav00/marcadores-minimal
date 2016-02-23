@extends('angular')

@section('content')

<div ng-app="partidosApp" ng-controller="PartidosCtrl">

	<div class="col-xs-10 col-xs-offset-1">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title text-center"><b>Wizard de manejo de partidos</b></div>
			</div>

			<div class="panel-body">

				{{-- informacion del torneo seleccionado --}}
				@include('partidos.partials.wizard_cabecera')
				

				<alert ng-repeat="alert in alerts" type="<%alert.type%>" dismiss-on-timeout="4000" close="closeAlert($index)"><%alert.msg%></alert>

				<!-- <div data-ng-switch="paso" ng-init="avanzarPaso()"> -->
				<div data-ng-switch="paso" ng-init="fake()">

					{{-- seleccionar el torneo a configurar --}}
					<div class="row" ng-switch-when="1">
						@include('partidos.partials.torneos')
					</div>

					{{-- seleccion de la fase --}}
					<div class="row" ng-switch-when="2">
						@include('partidos.partials.fases')
					</div>

					{{-- seleccion de la fecha --}}
					<div class="row" data-ng-switch-when="3">
						@include('partidos.partials.fechas')
					</div>

					{{-- seleccion del partido --}}
					<div class="row" data-ng-switch-when="4">
						@include('partidos.partials.partidos')
					</div>

					{{-- seleccion del titulares --}}
					<div class="row" data-ng-switch-when="5">
						@include('partidos.partials.titulares')
					</div>

					{{-- eventos del partido --}}
					<div class="row" data-ng-switch-when="6">
						@include('partidos.partials.eventos')
					</div>
				</div>

			</div>

			{{-- muestra los botones continuar o anterior --}}
			@include('partidos.partials.wizard_pie')
			
			<br>
			
		</div>
	</div>
</duv>

<script type="text/ng-template" id="goles.tpl">
	@include('partidos.partials.goles')
</script>

<script type="text/ng-template" id="sustituciones.tpl">
	@include('partidos.partials.sustituciones')
</script>

<script type="text/ng-template" id="amonestaciones.tpl">
	@include('partidos.partials.amonestaciones')
</script>

@endsection
