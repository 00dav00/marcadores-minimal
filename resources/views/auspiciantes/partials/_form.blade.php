<div class="form-group">
	<small>{!! Form::label('aus_nombre', 'Nombre') !!}</small>
	{!! Form::text('aus_nombre', null, array('class'=>'form-control input-sm','placeholder'=>'Nombre')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('aus_sitioweb', 'Sitio web') !!}</small>
	{!! Form::text('aus_sitioweb', null, array('class'=>'form-control input-sm','placeholder'=>'Sitio web')) !!}
</div>

<div class="form-group">
	<small>{!! Form::label('aus_imagen', 'Imagen') !!}</small>
	{!! Form::file('aus_imagen', array('class'=>'form-control input-sm','placeholder'=>'Imagen')) !!}
</div>