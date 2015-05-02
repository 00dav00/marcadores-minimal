<div class="form-group">
	<small>{!! Form::label('eqp_id', 'Equipo') !!}</small>
	<select id="eqp_id" name="eqp_id">
		<option value="{!! isset($eqp_id) ? $eqp_id : '' !!}">{!! isset($eqp_nombre) ? $eqp_nombre : 'Equipo ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('jug_id', 'Jugador') !!}</small>
	<select id="jug_id" name="jug_id">
		<option value="{!! isset($jug_id) ? $jug_id : '' !!}">{!! isset($jug_nombre) ? $jug_nombre : 'Jugador ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('tor_id', 'Torneo') !!}</small>
	<select id="tor_id" name="tor_id">
		<option value="{!! isset($tor_id) ? $tor_id : '' !!}">{!! isset($tor_nombre) ? $tor_nombre : 'Torneo ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('plt_numero_camiseta', 'Número de camiseta') !!}</small>
	{!! Form::text('plt_numero_camiseta', null, array('class'=>'form-control input-sm','placeholder'=>'Número de camiseta')) !!}
</div>

