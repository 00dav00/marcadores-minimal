<div class="form-group">
	<p><mark>Torneo:</mark> {!! $torneo !!}</p>
</div>
<div class="form-group">
	<p><mark>Fase:</mark> {!! $fase !!}</p>
</div>
<div class="form-group">
	<p><mark>Fecha:</mark> {!! $numero !!}</p>
</div>

<div class="form-group">
	<small>{!! Form::label('par_eqp_local', 'Equipo Local') !!}</small>
	{!! Form::select(
		'par_eqp_local', 
		$equipos, 
		[isset($par_eqp_local) ? $par_eqp_local : '']
	) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('par_eqp_visitante', 'Equipo Visitante') !!}</small>
	{!! Form::select(
		'par_eqp_visitante', 
		$equipos,  
		[isset($par_eqp_visitante) ? $par_eqp_visitante : '']
	) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('est_id', 'Estadio') !!}</small>
	<select id="est_id" name="est_id">
		<option value="{!! isset($est_id) ? $est_id : '' !!}">{!! isset($est_nombre) ? $est_nombre : 'Estadio ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('par_fecha', 'Fecha del Patido') !!}</small>
	{!! Form::text('par_fecha', null, array('class'=>'form-control input-sm','placeholder'=>'Fecha del Partido')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('par_hora', 'Hora del Patido') !!}</small>
	{!! Form::text('par_hora', null, array('class'=>'form-control input-sm','placeholder'=>'Hora del Partido')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('par_cronica', 'Crónica del Patido') !!}</small>
	{!! Form::text('par_cronica', null, array('class'=>'form-control input-sm','placeholder'=>'Crónica del Partido')) !!}
</div>