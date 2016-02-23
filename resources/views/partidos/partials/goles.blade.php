<div class="modal-header">
    <h3 class="modal-title">Goles</h3>
</div>
<alert ng-repeat="alert in alerts" type="<%alert.type%>" dismiss-on-timeout="15000" close="closeAlert($index)"><%alert.msg%></alert>
<div class="modal-body">
	<div class="form-group">
		<label for="gol_minuto">Minuto:</label>
		<input name="gol_minuto" class="form-control" type="number" 
			ng-model="nuevoGol.minuto"  min="1" max="120" value="1" />
	</div>
	<div class="form-group">
		<label for="gol_a_favor_de">A favor de:</label>
		<div name="gol_a_favor_de" class="btn-group-justified">
	    	<label ng-repeat="equipo in equipos" class="btn btn-default" ng-model="nuevoGol.equipo" btn-radio="equipo">
	    		<% equipo.eqp_nombre %>
			</label>
	    </div>		
	</div>
	<div class="form-group" >
		<label for="gol_jugador" class="control-label">Seleccionar Jugador</label>
		<select name="gol_jugador" class="form-control" ng-model="nuevoGol.autor" ng-options="autor.jug_nombre + ' ' + autor.jug_apellido for autor in jugadores">
			<option value="" disabled>Jugador ...</option>
		</select>
	</div>
	<div class="form-group" >
		<label for="gol_asistente" class="control-label">Seleccionar Asistente</label>
		<select name="gol_asistente" class="form-control" ng-model="nuevoGol.asistente" ng-options="asistente.jug_nombre + ' ' + asistente.jug_apellido for asistente in jugadores">
			<option value="" disabled>Jugador ...</option>
		</select>
	</div>
	<div class="form-group" >
		<label for="gol_jugada" class="control-label">Jugada</label>
		<select name="gol_jugada" class="form-control" ng-model="nuevoGol.jugada" ng-options="jugada for jugada in jugadas">
			<option value="" disabled>Jugada ...</option>
		</select>
	</div>
	<div class="form-group" >
		<label for="gol_ejecucion" class="control-label">Ejecucion</label>
		<select name="gol_ejecucion" class="form-control" ng-model="nuevoGol.ejecucion" ng-options="ejecucion for ejecucion in ejecuciones">
			<option value="" disabled>Ejecucion ...</option>
		</select>
	</div>
	
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="button" ng-click="ok(nuevoGol)">OK</button>
    <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
</div>
