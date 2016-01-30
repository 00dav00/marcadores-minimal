<div class="form-group" >
	<label for="tor_id" class="control-label">Seleccionar Torneo</label>
	<select id="tor_id" name="tor_id" class="form-control" ng-model="$parent.torneoSeleccionado"
		ng-options="torneo as torneo.tor_nombre for torneo in torneos" ng-change="seleccionarTorneo()">
		<option value="" disabled>Torneo ...</option>
	</select>
</div>