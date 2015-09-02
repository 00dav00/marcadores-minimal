@extends('widget')

@section('widget')
<div class="container-fluid">

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">

			<div class="row" ng-app="fechasApp" ng-controller="FechasCtrl" data-ng-init="initPreview({!! $fecha_id !!},{!! $fase_id !!})">

				<table class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<tbody>
						<tr class="row">

							<td class="col-xs-1 col-sm-1 col-md-1 col-lg-1" >
								<button class="btn btn-success btn-md"  ng-disabled="!existeFechaAnterior" ng-click="irFechaAnterior(irFechaWidget)">  
									<span class="glyphicon glyphicon-chevron-left" ></span>
								</button>
							</td>

							<td class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
								<div class="info">
									<b><% faseSeleccionada.torneo.tor_nombre %> </b>
									<% faseSeleccionada.tipo_fase.tfa_nombre %>, Fecha <% fechaSeleccionada.fec_numero %> 
								</div>
								
								<div class="row">
									<span class="col-xs-10 col-sm-5 col-md-4 col-lg-2" ng-repeat='partido in partidos'>
										<table class="table table-striped table-bordered table-condensed">
											<thead>
												<tr>
													<td colspan="3">
														<b><% partido.par_fecha %></b> 
														<span class="hidden-xs hidden-sm"> &nbsp; <% partido.par_hora %> <span>
													</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="equiposImagenRight col-xs-1"> <img class="escudoEquiposMini" src="/<% partido.equipo_local.eqp_escudo %>"/> </td>
													<td class="equiposImagenLeft col-xs-3"><% partido.equipo_local.eqp_nombre_corto %></td>
													<td class="col-xs-1"> <% partido.par_goles_local %> </td>
												</tr>
												<tr>
													<td class="equiposImagenRight"> <img class="escudoEquiposMini" src="/<% partido.equipo_visitante.eqp_escudo %>"/> </td>
													<td class="equiposImagenLeft"><% partido.equipo_visitante.eqp_nombre_corto %></td>
													<td> <% partido.par_goles_visitante %> </td>
												</tr>
												<tr>
													<td class="estadioPartido" colspan="3"><b><% partido.estadio.est_nombre %></b></td>
												</tr>
											</tbody>
										</table>
									</span>
								</div>
							</td>

							<td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
								<button class="btn btn-success btn-md" ng-disabled="!existeFechaSiguiente" ng-click="irFechaSiguiente(irFechaWidget)">  
									<span class="glyphicon glyphicon-chevron-right" ></span>
								</button>
							</td>
						</tr>
						
					</tbody>
				</table>

			</div>

		</div>

	</div>
</div>


@endsection