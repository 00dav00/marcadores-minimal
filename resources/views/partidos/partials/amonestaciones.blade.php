<div class="modal-header">
    <h3 class="modal-title">Amonestaciones</h3>
</div>

<alert ng-repeat="alert in alerts" type="<%alert.type%>" dismiss-on-timeout="15000" close="closeAlert($index)"><%alert.msg%></alert>

<div class="modal-body">
	<div class="form-group">
		<label for="amonestacion_minuto">Minuto:</label>
		<input name="amonestacion_minuto" class="form-control" type="number"
			ng-model="nuevaAmonestacion.minuto"  min="1" max="120" value="1" />
	</div>
	<div class="form-group">
		<label for="equipo_amonestacion">Equipo:</label>
		<div name="equipo_amonestacion" class="btn-group-justified">
	    	<label ng-repeat="equipo in equipos" class="btn btn-default" ng-model="nuevaAmonestacion.equipo"
	    		btn-radio="equipo" ng-click="seleccionarEquipo($index)">
	    		<% equipo.eqp_nombre %>
			</label>
	    </div>		
	</div>
	<div class="form-group" >
		<label for="jugador_amonestado" class="control-label">Seleccionar jugador amonestado</label>
		<select name="jugador_amonestado" class="form-control" ng-model="nuevaAmonestacion.jugador"
			ng-options="jugador.jug_nombre + ' ' + jugador.jug_apellido for jugador in en_cancha" ng-disabled="en_cancha.length < 1">
			<option value="" disabled>Jugador ...</option>
		</select>
	</div>
	<div class="form-group">
		<label for="tarjeta_amonestacion">Tarjeta:</label>
		<div name="tarjeta_amonestacion" class="btn-group-justified">
	    	<label ng-repeat="tarjeta in tarjetas" class="btn btn-default" ng-model="nuevaAmonestacion.tipo"
	    		btn-radio="tarjeta" ng-click="seleccionarTarjeta($index)">
	    		<% tarjeta %>
			</label>
	    </div>		
	</div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="button" ng-click="ok(nuevaAmonestacion)">OK</button>
    <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
</div>
