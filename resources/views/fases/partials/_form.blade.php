<div class="form-group">
	<small>{!! Form::label('fas_descripcion', 'Descripción') !!}</small>
	{!! Form::text('fas_descripcion', null, array('class'=>'form-control input-sm','placeholder'=>'Descripción')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('tfa_id', 'Tipo de Fase') !!}</small>
	<select id="tfa_id" name="tfa_id">
		<option value="{!! isset($tfa_id) ? $tfa_id : '' !!}">{!! isset($tfa_nombre) ? $tfa_nombre : 'Tipo de Fase ...' !!}</option>
	</select>
</div>

<div class="form-group">
	<small>{!! Form::label('tor_id', 'Nombre del torneo') !!}</small>
	<select id="tor_id" name="tor_id">
		<option value="{!! isset($tor_id) ? $tor_id : '' !!}">{!! isset($tor_nombre) ? $tor_nombre : 'Nombre del torneo ...' !!}</option>
	</select>
</div>