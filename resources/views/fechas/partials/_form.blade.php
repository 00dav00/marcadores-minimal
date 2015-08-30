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
	<small>{!! Form::label('fec_estado', 'Tipo') !!}</small>
	{!! Form::select('fec_estado', ['jugada' => 'Jugada' , 'no_jugada' => 'No jugada' , 'en_juego' => 'En juego', 'suspendida' => 'Suspendida' ], null, ['class' => 'form-control input-sm']) !!}	
</div>