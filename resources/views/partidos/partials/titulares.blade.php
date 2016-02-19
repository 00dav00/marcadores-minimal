<style>
	.even{ background-color: #f3f3f3 !important; }
	.odd{ background-color: #ffffff !important; }
</style>


<div>
	<div class="panel panel-default">
		
		<div class="panel-heading">
			<h4 class="text-center">Jugadores Titulares</h4>
		</div>
		<div class="panel-body">
			<table style="width:100%">
				<thead>
					<tr>
						<td>Local</td>
						<td>Visitante</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="caption" style="width: 50%; padding-right: 8px; vertical-align: text-top;">
							<div ng-repeat="jugador in plantillas.local" ng-class="['even', 'odd'][$index %2]"> 
								<input type="checkbox" value="<% jugador.jug_id %>" ng-model="jugador.seleccionado" 
									ng-change="ingresarTitularesPorPlantilla(plantillas.local, partidoSeleccionado.equipo_local)" ng-disabled="jugador.bloqueado">
						  		<% jugador.jug_nombre %> &nbsp; <% jugador.jug_apellido %><br/>
							</div>
						</td>
						<td class="caption" style="width: 50%; padding-left: 8px; vertical-align: text-top;">
							<div ng-repeat="jugador in plantillas.visitante" ng-class="['odd', 'even'][$index %2]"> 
								<input type="checkbox" value="<% jugador.jug_id %>" ng-model="jugador.seleccionado" 
									ng-change="ingresarTitularesPorPlantilla(plantillas.visitante, partidoSeleccionado.equipo_visitante)" ng-disabled="jugador.bloqueado"> 
						  		<% jugador.jug_nombre %> &nbsp; <% jugador.jug_apellido %><br/>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>

