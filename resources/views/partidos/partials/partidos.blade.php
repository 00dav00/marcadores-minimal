<table class="table table-hover table-condensed">
	<thead>
		<tr class="row">
			<td class="text-center" colspan="3" >Local</td>
			<td class="text-center">&nbsp;&nbsp;&nbsp;</td>
			<td class="text-center" colspan="3" >Visitante</td>
			<td class="text-center">Fecha</td>
			<td class="text-center">Editar</td>
		</tr>
	</thead>
	<tbody>
		<tr class="row" ng-repeat-start='partido in partidos' >
		</tr>
		
		<tr class="row" ng-repeat-end  ng-class="['even', 'odd'][$index %2]">
			<td class="text-left" > <img src="/<% partido.equipo_local.eqp_escudo %>" style="max-width:22px;max-height:26px;"/> </td>
			<td class="text-left"> <% partido.equipo_local.eqp_nombre_corto %> </td>
			<td class="text-left"> <% partido.par_goles_local %> </td>
			<td class="text-center">
				<span ng-if="partido.par_goles_local != null"><b>&nbsp;x&nbsp;</b></span>
				<span ng-if="partido.par_goles_local == null"><b>vs</b></span>
			</td>
			<td class="text-right"> <% partido.par_goles_visitante %> </td>
			<td class="text-right"> <% partido.equipo_visitante.eqp_nombre_corto %> </td>
			<td class="text-right"> <img src="/<% partido.equipo_visitante.eqp_escudo %>" style="max-width:22px;max-height:26px;"/> </td>
			<td class="text-center">
				<span ng-if="partido.par_fecha != null"> <% partido.par_fecha %> </span>
				<span ng-if="partido.par_fecha == null"><b>DIFERIDO</b></span>
			</td>
			<td class="text-center">
				<button class="btn btn-primary btn-xs" ng-click="seleccionarPartido(partido)">
					<span class="glyphicon glyphicon-paste" ></span>
				</button>
			</td>
		</tr>

	</tbody>
</table>