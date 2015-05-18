<div class="text-center">

	{!! Form::open(['route' => "$route.index", 'method' => 'GET', 'class' => 'form-inline']) !!}

		<div class="form-group">
			{!! Form::label('keyword', 'Búsqueda', ['class' => 'sr-only']) !!}
			{!! Form::text('keyword', null, array('class'=>'form-control','placeholder'=>'Búsqueda')) !!}
		</div>

		<div class="form-group">
			{!! Form::label('column', 'Tipo', ['class' => 'sr-only']) !!}
			{!! Form::select('column', $searchFields, null, ['class' => 'form-control']) !!}
		</div>

		{!! Form::submit('Buscar', array('class'=>'btn btn-default')) !!}

	{!! Form::close() !!}
</div>

<br>