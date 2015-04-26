<div class="form-group">
	<small>{!! Form::label('lug_abreviatura', 'Abreviatura') !!}</small>
	{!! Form::text('lug_abreviatura', null, array('class'=>'form-control input-sm','placeholder'=>'Abreviatura')) !!}
</div>
<div class="form-group">
	<small>{!! Form::label('lug_nombre', 'Nombre') !!}</small>
	{!! Form::text('lug_nombre', null, array('class'=>'form-control input-sm','placeholder'=>'Nombre')) !!}
</div>
<div class="form-group">
	<small>{!! Form::label('lug_tipo', 'Tipo') !!}</small>
	{!! Form::select('lug_tipo', ['continente' => 'Continente', 'pais' => 'País', 'provincia' => 'Provincia', 'ciudad' => 'Ciudad'], null, ['class' => 'form-control input-sm']) !!}
</div>
<div class="form-group">
	<small>{!! Form::label('parent_lug_id', 'Pertenece a') !!}</small>
	<select id="parent_lug_id" name="parent_lug_id">
		<option value="{!! isset($lug_id) ? $lug_id : '' !!}">{!! isset($lug_nombre) ? $lug_nombre : 'Pertenece a ...' !!}</option>
	</select>
</div>