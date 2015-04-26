<div class="form-group">
	<small>{!! Form::label('tor_nombre', 'Nombre') !!}</small>
	{!! Form::text('tor_nombre', null, array('class'=>'form-control input-sm','placeholder'=>'Nombre')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('tor_anio_referencia', 'Año de referencia') !!}</small>
	{!! Form::text('tor_anio_referencia', null, array('class'=>'form-control input-sm','placeholder'=>'Año de referencia')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('tor_fecha_inicio', 'Fecha de inicio') !!}</small>
	{!! Form::text('tor_fecha_inicio', null, array('class'=>'form-control input-sm','placeholder'=>'Fecha de inicio')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('tor_fecha_fin', 'Fecha de finalización') !!}</small>
	{!! Form::text('tor_fecha_fin', null, array('class'=>'form-control input-sm','placeholder'=>'Fecha de finalización')) !!}
</div>


<div class="form-group">
	<small>{!! Form::label('tor_tipo_equipos', 'Tipo de torneo') !!}</small>
	{!! Form::select('tor_tipo_equipos', ['seleccion' => 'Seleccion', 'profesional' => 'Profesional', 'amateur' => 'Amateur'], null, ['class' => 'form-control input-sm']) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('ttr_codigo', 'Tipo de torneo') !!}</small>
	<select id="ttr_codigo" name="ttr_codigo">
		<option value="{!! isset($ttr_codigo) ? $ttr_codigo : '' !!}">{!! isset($ttr_nombre) ? $ttr_nombre : 'Tipo de torneo ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('lug_id', 'Lugar') !!}</small>
	<select id="lug_id" name="lug_id">
		<option value="{!! isset($lug_id) ? $lug_id : '' !!}">{!! isset($lug_nombre) ? $lug_nombre : 'Lugar ...' !!}</option>
	</select>
</div>