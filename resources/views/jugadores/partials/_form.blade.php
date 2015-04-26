<div class="form-group">
	<small>{!! Form::label('jug_apellido', 'Apellido') !!}</small>
	{!! Form::text('jug_apellido', null, array('class'=>'form-control input-sm','placeholder'=>'Apellido')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('jug_nombre', 'Nombre') !!}</small>
	{!! Form::text('jug_nombre', null, array('class'=>'form-control input-sm','placeholder'=>'Nombre')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('jug_apodo', 'Apodo') !!}</small>
	{!! Form::text('jug_apodo', null, array('class'=>'form-control input-sm','placeholder'=>'Apodo')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('jug_fecha_nacimiento', 'Fecha de nacimiento') !!}</small>
	{!! Form::text('jug_fecha_nacimiento', null, array('class'=>'form-control input-sm','placeholder'=>'Fecha de nacimiento')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('jug_altura', 'Altura') !!}</small>
	{!! Form::text('jug_altura', null, array('class'=>'form-control input-sm','placeholder'=>'Altura')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('jug_sitioweb', 'Sitio web') !!}</small>
	{!! Form::text('jug_sitioweb', null, array('class'=>'form-control input-sm','placeholder'=>'Sitio web')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('jug_twitter', 'Twitter') !!}</small>
	{!! Form::text('jug_twitter', null, array('class'=>'form-control input-sm','placeholder'=>'Twitter')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('jug_foto', 'Foto') !!}</small>
	{!! Form::file('jug_foto', array('class'=>'form-control input-sm','placeholder'=>'Foto')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('lug_id', 'Nacionalidad') !!}</small>
	<select id="lug_id" name="lug_id">
		<option value="{!! isset($lug_id) ? $lug_id : '' !!}">{!! isset($lug_nombre) ? $lug_nombre : 'Nacionalidad ...' !!}</option>
	</select>
</div>