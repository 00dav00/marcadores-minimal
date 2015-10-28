
<table class="table table-striped">
	<thead>
		<td class="center"><b> Equipo </b></td>
		<td class="center"><b> Editar Plantilla </b></td>
	</thead>
	<tbody>
		<tr ng-repeat='equipo in equipos'>
			<td><% equipo.eqp_nombre %></td>
			<td>
				<button class="btn btn-primary btn-xs" ng-click="seleccionarEquipo(equipo)">
					<span class="glyphicon glyphicon-paste" ></span>
				</button>
			</td>
		</tr>
	</tbody>
</table>