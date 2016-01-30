<table class="table table-striped">
	<thead>
		<td class="center"><b> Fase </b></td>
		<td class="center text-center"><b> Seleccionar </b></td>
	</thead>
	<tbody>
		<tr ng-repeat='fase in fases'>
			<td><% fase.tipo_fase.tfa_nombre %></td>
			<td class="text-center">
				<button class="btn btn-primary btn-xs" ng-click="seleccionarFase(fase)">
					<span class="glyphicon glyphicon-paste" ></span>
				</button>
			</td>
		</tr>
	</tbody>
</table>