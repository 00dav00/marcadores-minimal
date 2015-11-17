<div class="row" ng-if="torneoSeleccionado">
					
	<div class="well text-center">
		<h4><% torneoSeleccionado.tor_nombre %></h4>
		<p>
			Inicio: <% torneoSeleccionado.tor_fecha_inicio %> &nbsp;-&nbsp;
			Fin: <% torneoSeleccionado.tor_fecha_fin %>
		</p>

		{{-- informacion de la fase seleccionada --}}
		<p ng-if="faseSeleccionada"> Fase: <% faseSeleccionada.tipo_fase.tfa_nombre %> </p> 
		{{-- informacion de la fecha seleccionada --}}
		<p ng-if="fechaSeleccionada">Fecha: <% fechaSeleccionada.fec_numero %> </p>
		{{-- informacion del partido seleccionado --}}
		<p ng-if="partidoSeleccionado"> 
			<b><% partidoSeleccionado.equipo_local.eqp_nombre_corto %> vs 
			<% partidoSeleccionado.equipo_visitante.eqp_nombre_corto %> </b>
		</p>						
	</div>

</div>