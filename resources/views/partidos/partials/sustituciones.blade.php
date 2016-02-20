<div class="modal-header">
    <h3 class="modal-title">Nueva sustitución</h3>
</div>

<alert ng-repeat="alert in alerts" type="<%alert.type%>" dismiss-on-timeout="15000" close="closeAlert($index)"><%alert.msg%></alert>

<div class="modal-body">
	<div class="form-group">
		<label for="sustitucion_minuto">Minuto:</label>
		<input name="sustitucion_minuto" class="form-control" type="number" 
			ng-model="nuevaSustitucion.minuto"  min="1" max="120" value="1" />
	</div>
	<div class="form-group">
		<label for="equipo_sustitucion">A favor de:</label>
		<div name="equipo_sustitucion" class="btn-group-justified">
	    	<label ng-repeat="equipo in equipos" class="btn btn-default" ng-model="nuevaSustitucion.equipo" btn-radio="equipo">
	    		<% equipo.eqp_nombre %>
			</label>
	    </div>		
	</div>
	<div class="form-group" >
		<label for="sustitucion_sale" class="control-label">Seleccionar jugador sustituido</label>
		<select name="sustitucion_sale" class="form-control" ng-model="nuevaSustitucion.sale" ng-options="sale.jug_nombre + ' ' + sale.jug_apellido for sale in en_cancha">
			<option value="" disabled>Jugador ...</option>
		</select>
	</div>
	<div class="form-group" >
		<label for="sustitucion_ingresa" class="control-label">Seleccionar jugador que ingresa</label>
		<select name="sustitucion_ingresa" class="form-control" ng-model="nuevaSustitucion.ingresa" ng-options="ingresa.jug_nombre + ' ' + ingresa.jug_apellido for ingresa in disponibles">
			<option value="" disabled>Jugador ...</option>
		</select>
	</div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="button" ng-click="ok()">OK</button>
    <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
</div>
