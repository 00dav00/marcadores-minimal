<table class="table table-striped">
	<thead>
		<td class="center"><b> Fechas </b></td>
		<td class="center"><b> Estado </b></td>
		<td class="center"><b> # Partidos </b></td>
		<td class="center text-center"><b> Seleccionar </b></td>
	</thead>
	<tbody>
		<tr ng-repeat='fecha in fechas'>
			<td class="center"><% fecha.fec_numero %></td>
			<td class="center"><% fecha.fec_estado %></td>
			<td class="text-center"><% fecha.partidos_conteo[0].contador %></td>
			<td class="text-center">
				<button class="btn btn-primary btn-xs" ng-click="seleccionarFecha(fecha)">
					<span class="glyphicon glyphicon-paste" ></span>
				</button>
			</td>
		</tr>
	</tbody>
</table>