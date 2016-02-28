@extends('resultados')

@section('stylesheets')

<link href="{!! asset('/assets/css/cancheros/resultados/resultados.css') !!}" rel="stylesheet">

@endsection

@section('content')

<div ng-app="resultadosTorneo" ng-controller="resultadosController as res" ng-init="res.init({{$torneo}}, {{$cliente}})" class="container">

	<main>
		<section class="row posiciones">

			<ul class="list-group">
				<li class="list-group-item informacion" ng-repeat="partido in res.fecha.partidos">
					<div class="row partido">

						<div class="row partido">
							<div class="text-center col-xs-5 equipo text-uppercase"><h4><b>@{{ res.equipos[partido.par_eqp_local].eqp_nombre_corto }}</b></h4></div>

							<div class="text-center col-xs-2">
								<img ng-src="/@{{ res.equipos[partido.par_eqp_local].eqp_escudo }}" alt="@{{ res.equipos[partido.par_eqp_local].eqp_abreviatura }}" style="max-width:25px;max-height:25px;"/>
							</div>

							<div ng-if="partido.par_goles_local == null" class="text-center">
								<div class="col-xs-1"></div>
								<h4 class="col-xs-2 goles">vs</h4>
								<div class="col-xs-1"></div>
							</div>

							<div ng-if="partido.par_goles_local != null" class="text-center">
								<div class="col-xs-1 text-center goles">
									<h4>@{{ partido.par_goles_local }}</h4>
								</div>
								<div class="col-xs-2 text-center">
									<h4>-</h4>
								</div>
								<div class="col-xs-1 text-center goles">
									<h4>@{{ partido.par_goles_visitante }}</h4>
								</div>
							</div>

							<div class="col-xs-2 text-center">
								<img ng-src="/@{{ res.equipos[partido.par_eqp_visitante].eqp_escudo }}" alt="@{{ res.equipos[partido.par_eqp_visitante].eqp_abreviatura }}" style="max-width:25px;max-height:25px;"/>
							</div>

							<div class="text-center col-xs-5 equipo text-uppercase"><h4><b>@{{ res.equipos[partido.par_eqp_visitante].eqp_nombre_corto }}</b></h4></div>
						</div>

						<div class="row estadio">
							<div class="text-center">
								<h4>@{{ partido.estadio.est_nombre }}</h4>
								<div ng-if="partido.par_fecha != null">
									<h5>@{{ partido.par_fecha }} | @{{ partido.par_hora | limitTo:5 }}</h5>
								</div>
								<div ng-if="partido.par_fecha == null">
									<h5>POSTERGADO</h5>
								</div>
							</div>
						</div>

					</div>
				</li>
			</ul>

			<div class="row">
				<div class="col-xs-12 text-center">
					<div ng-if="res.proximas.anterior != null" class="btn-group btn-group-sm" role="group">
						<button class="btn btn-default botones" ng-click="res.cambiarFecha(res.proximas.anterior)"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Anterior</button>
					</div>
					<div ng-if="res.proximas.siguiente != null" class="btn-group btn-group-sm" role="group">
						<button class="btn btn-default botones" ng-click="res.cambiarFecha(res.proximas.siguiente)">Siguiente <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
					</div>
				</div>
				<div class="col-xs-6 text-right">
					<p class="text-center"><img src="/images/dataprensa.png" alt="DataPrensa logo"></p>
				</div>
			</div>

		</section>

	</main>
	
</div>

@endsection