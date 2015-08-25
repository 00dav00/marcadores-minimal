@extends('visual')

@section('widget')
<div class="row" ng-app="fechasApp" ng-controller="FechasCtrl" data-ng-init="initPreview({!! $fecha_id !!})">

				<table class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<tbody>
						<tr class="row">

							<td class="col-xs-2 col-sm-2 col-md-1 col-lg-1" >
								<button class="btn btn-success btn-md" >  
									<span class="glyphicon glyphicon-chevron-left" ></span>
								</button>
							</td>
							<td class="col-xs-8 col-sm-8 col-md-10 col-lg-10">
								<div class="panel-heading">
									<b><% faseSeleccionada.torneo.tor_nombre %> </b>
									<% faseSeleccionada.tipo_fase.tfa_nombre %>, Fecha <% fechaSeleccionada.fec_numero %> 
								</div>
								
								<div class="row">
									<span class="col-xs-8 col-sm-8 col-md-2 col-lg-2" ng-repeat='partido in partidos'>
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<td colspan="3">
														<% partido.par_fecha %> &nbsp; <% partido.par_hora %>
													</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td> <img src="/<% partido.equipo_local.eqp_escudo %>" style="max-width:20px;max-height:20px;"/> </td>
													<td> <% partido.equipo_local.eqp_nombre_corto %> </td>
													<td> <% partido.par_goles_local %> </td>
												</tr>
												<tr>
													<td> <img src="/<% partido.equipo_visitante.eqp_escudo %>" style="max-width:20px;max-height:20px;"/> </td>
													<td> <% partido.equipo_visitante.eqp_nombre_corto %> </td>
													<td> <% partido.par_goles_visitante %> </td>
												</tr>
											</tbody>
										</table>
									</span>
								</div>
							</td>
							<td class="col-xs-2 col-sm-8 col-md-1 col-lg-10">
								<button class="btn btn-success btn-md" ng-click="actualizarJugadorEnPlantilla()">  
									<span class="glyphicon glyphicon-chevron-right" ></span>
								</button>
							</td>
						</tr>
						
					</tbody>
				</table>
</div>


@endsection