<div class="form-group">
	<small>{!! Form::label('eqp_nombre', 'Nombre') !!}</small>
	{!! Form::text('eqp_nombre', null, array('class'=>'form-control input-sm','placeholder'=>'Nombre')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('eqp_fecha_fundacion', 'Fecha de fundación') !!}</small>
	{!! Form::text('eqp_fecha_fundacion', null, array('class'=>'form-control input-sm','placeholder'=>'Fecha de fundación')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('eqp_escudo', 'Escudo') !!}</small>
	{!! Form::file('eqp_escudo', array('class'=>'form-control input-sm','placeholder'=>'Escudo')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('eqp_twitter', 'Facebook') !!}</small>
	{!! Form::text('eqp_twitter', null, array('class'=>'form-control input-sm','placeholder'=>'Usuario de Facebook')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('eqp_facebook', 'Twitter') !!}</small>
	{!! Form::text('eqp_facebook', null, array('class'=>'form-control input-sm','placeholder'=>'Twitter')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('eqp_sitioweb', 'Sitio web') !!}</small>
	{!! Form::text('eqp_sitioweb', null, array('class'=>'form-control input-sm','placeholder'=>'Sitio web')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('eqp_tipo', 'Tipo') !!}</small>
	{!! Form::select('eqp_tipo', ['seleccion' => 'Seleccion', 'profesional' => 'Profesional', 'amateur' => 'Amateur'], null, ['class' => 'form-control input-sm']) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('lug_id', 'Lugar') !!}</small>
	<select id="lug_id" name="lug_id">
		<option value="{!! isset($lug_id) ? $lug_id : '' !!}">{!! isset($lug_nombre) ? $lug_nombre : 'Lugar ...' !!}</option>
	</select>
</div>