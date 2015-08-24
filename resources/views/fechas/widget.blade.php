@extends('visual')

@section('widget')

<!-- <div class="container-fluid"> -->
<div class="row">
      <div class="col-sm-12">
          <div class="container">
              <div class="row">
                  <div class="col-sm-6">
                      <p>Nunc congue, enim nec faucibus rutrum, orci magna bibendum odio, nec euismod lectus neque at felis. Vestibulum lectus arcu, aliquet vel vulputate sed, aliquet convallis massa. Aenean urna ante, pretium in pellentesque at, posuere vitae urna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec in ipsum urna, id aliquet erat. Aliquam id nisi eu nunc pulvinar faucibus quis quis erat. Aliquam placerat auctor lectus, sit amet consectetur ipsum lacinia sit amet.</p>
                      <p>Duis vulputate bibendum elementum. Phasellus eu sodales ligula. Vivamus at justo mauris, id pretium libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas hendrerit dolor sit amet urna lacinia porttitor. Integer sed gravida turpis. Etiam varius nulla nulla, volutpat porta risus. Nullam sollicitudin augue posuere nisl sollicitudin ultrices. Morbi dignissim mauris varius orci placerat luctus. Aliquam et risus nulla, ac tincidunt augue. Integer interdum convallis nibh. Maecenas porttitor, leo at sollicitudin posuere, neque sem porttitor odio, et convallis sem massa id dolor. Sed molestie justo id lacus luctus vel commodo sem vestibulum. Vestibulum venenatis risus quis dui consectetur tempus. Suspendisse ultricies turpis sed odio laoreet imperdiet vel ac erat. In mattis enim ut orci tincidunt condimentum.</p>
                  </div>
                  <div class="col-sm-6">
                      <p>Phasellus non nibh ante, a elementum quam. Donec cursus fringilla dui et iaculis. Aenean rhoncus erat accumsan orci mollis vitae malesuada metus euismod. Maecenas aliquet leo et dui venenatis pulvinar sit amet id mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed non purus sed tellus vehicula ullamcorper. Curabitur in nisi faucibus enim rutrum placerat. Morbi consequat, magna at convallis tempus, eros ante cursus neque, quis fermentum quam est a est. Mauris non arcu nulla. Vestibulum facilisis pulvinar augue nec egestas. In iaculis diam in libero facilisis eu rutrum arcu elementum. Phasellus viverra porttitor interdum. Donec vel elit vel erat sollicitudin sollicitudin.</p>
                      <p>Ut libero turpis, tristique et euismod quis, feugiat eu lorem. Nulla facilisi. Donec nec cursus nisi. Suspendisse tempor egestas rutrum. Pellentesque ac velit eget nisl auctor tincidunt in at risus. Integer lacinia neque vel lacus ornare vehicula suscipit dolor suscipit. Nunc quam diam, consequat pulvinar egestas quis, congue ac lacus. Donec pharetra posuere lacus, eget egestas est feugiat vel. Fusce orci dolor, lacinia aliquet mollis quis, posuere at diam. Curabitur non nibh massa, elementum luctus dolor. Curabitur elit odio, elementum sit amet placerat ac, ullamcorper sagittis purus. Integer odio dolor, scelerisque nec hendrerit non, laoreet ut augue. Curabitur lorem odio, lacinia ac placerat in, condimentum a velit.</p>
                  </div>
              </div>
          </div>
      </div>
</div>
<!-- </div> -->

<div class="row" ng-app="fechasApp" ng-controller="FechasCtrl" data-ng-init="initPreview({!! $fecha_id !!})">
	<div class="col-xs-12 col-md-12 col-sm-12">
		<div class="container">			
          	<div class="row">
          		<div class="col-xs-12 col-md-12 col-sm-12">
          			<p>Phasellus non nibh ante, a elementum quam. Donec cursus fringilla dui et iaculis. Aenean rhoncus erat accumsan orci mollis vitae malesuada metus euismod. Maecenas aliquet leo et dui venenatis pulvinar sit amet id mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed non purus sed tellus vehicula ullamcorper. Curabitur in nisi faucibus enim rutrum placerat. Morbi consequat, magna at convallis tempus, eros ante cursus neque, quis fermentum quam est a est. Mauris non arcu nulla. Vestibulum facilisis pulvinar augue nec egestas. In iaculis diam in libero facilisis eu rutrum arcu elementum. Phasellus viverra porttitor interdum. Donec vel elit vel erat sollicitudin sollicitudin.</p>
                  	<p>Ut libero turpis, tristique et euismod quis, feugiat eu lorem. Nulla facilisi. Donec nec cursus nisi. Suspendisse tempor egestas rutrum. Pellentesque ac velit eget nisl auctor tincidunt in at risus. Integer lacinia neque vel lacus ornare vehicula suscipit dolor suscipit. Nunc quam diam, consequat pulvinar egestas quis, congue ac lacus. Donec pharetra posuere lacus, eget egestas est feugiat vel. Fusce orci dolor, lacinia aliquet mollis quis, posuere at diam. Curabitur non nibh massa, elementum luctus dolor. Curabitur elit odio, elementum sit amet placerat ac, ullamcorper sagittis purus. Integer odio dolor, scelerisque nec hendrerit non, laoreet ut augue. Curabitur lorem odio, lacinia ac placerat in, condimentum a velit.</p>
          		</div>
				<table class="col-xs-12 col-md-12 col-sm-12">
					<tr class="col-xs-12 col-md-12 col-sm-12">
						<td class="col-xs-2 col-md-1" >
							<button class="btn btn-success btn-md" >  
								<span class="glyphicon glyphicon-chevron-left" ></span>
							</button>
						</td>
						<td class="col-xs-8 col-md-10">
							<div class="panel-heading col-xs-8 col-md-10">
								<b><% faseSeleccionada.torneo.tor_nombre %> </b>
								<% faseSeleccionada.tipo_fase.tfa_nombre %>, Fecha <% fechaSeleccionada.fec_numero %> 
							</div>
							
							<div class="form-group">
								<span class="col-xs-4" ng-repeat='partido in partidos'>
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
												<td> <img src="<% partido.equipo_local.eqp_escudo %>" style="max-width:30px;max-height:30px;"/> </td>
												<td> <% partido.equipo_local.eqp_nombre %> </td>
												<td> <% partido.par_goles_local %> </td>
											</tr>
											<tr>
												<td> <img src="<% partido.equipo_visitante.eqp_escudo %>" style="max-width:30px;max-height:30px;"/> </td>
												<td> <% partido.equipo_visitante.eqp_nombre %> </td>
												<td> <% partido.par_goles_visitante %> </td>
											</tr>
										</tbody>
									</table>
								</span>
							</div>
						</td>
						<td class="col-xs-2 col-md-1">
							<button class="btn btn-success btn-md" ng-click="actualizarJugadorEnPlantilla()">  
								<span class="glyphicon glyphicon-chevron-right" ></span>
							</button>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection