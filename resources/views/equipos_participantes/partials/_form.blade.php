<div class="form-group">
	<small>{!! Form::label('eqp_id', 'Equipo') !!}</small>
	<select id="eqp_id" name="eqp_id">
		<option value="{!! isset($eqp_id) ? $eqp_id : '' !!}">{!! isset($eqp_nombre) ? $eqp_nombre : 'Equipo ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('tor_id', 'Torneo') !!}</small>
	<select id="tor_id" name="tor_id">
		<option value="{!! isset($tor_id) ? $tor_id : '' !!}">{!! isset($tor_nombre) ? $tor_nombre : 'Torneo ...' !!}</option>
	</select>
</div>