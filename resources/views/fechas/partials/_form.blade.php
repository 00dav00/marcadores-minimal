<div class="form-group">
	<small>{!! Form::label('fas_id', 'Tipo de Fase') !!}</small>
	<select id="fas_id" name="fas_id">
		<option value="{!! isset($fas_id) ? $fas_id : '' !!}">{!! isset($fas_descripcion) ? $fas_descripcion : 'Fase ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('fec_numero', 'Número') !!}</small>
	{!! Form::text('fec_numero', null, array('class'=>'form-control input-sm','placeholder'=>'Número')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('fec_fecha_referencia', 'Fecha de referencia') !!}</small>
	{!! Form::text('fec_fecha_referencia', null, array('class'=>'form-control input-sm','placeholder'=>'Fecha de referencia')) !!}
</div>