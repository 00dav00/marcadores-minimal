<div class="form-group">
	<small>{!! Form::label('est_nombre', 'Nombre') !!}</small>
	{!! Form::text('est_nombre', null, array('class'=>'form-control input-sm','placeholder'=>'Nombre')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('est_fecha_inauguracion', 'Fecha de inauguración') !!}</small>
	{!! Form::text('est_fecha_inauguracion', null, array('class'=>'form-control input-sm','placeholder'=>'Fecha de inauguración')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('est_foto_por_defecto', 'Foto') !!}</small>
	{!! Form::file('est_foto_por_defecto', array('class'=>'form-control input-sm','placeholder'=>'Foto')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('est_aforo', 'Aforo') !!}</small>
	{!! Form::text('est_aforo', null, array('class'=>'form-control input-sm','placeholder'=>'Aforo')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('lug_id', 'Ubicación') !!}</small>
	<select id="lug_id" name="lug_id">
		<option value="{!! isset($lug_id) ? $lug_id : '' !!}">{!! isset($lug_nombre) ? $lug_nombre : 'Ubicación ...' !!}</option>
	</select>
</div>