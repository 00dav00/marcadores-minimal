@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Jugador a una Plantilla</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::open(array('route' => 'plantillas.store')) !!}
					@include('plantillas.partials._form')
					{!! Form::submit('Agregar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@include('partials.selectize', ['id' => '#tor_id', 'valueField' => 'tor_id', 'labelField' => 'tor_nombre', 'url' => '/api/torneos/consulta'])

@include('partials.selectize', ['id' => '#eqp_id', 'valueField' => 'eqp_id', 'labelField' => 'eqp_nombre', 'url' => '/api/equipos/consulta'])

@include('partials.selectize', ['id' => '#jug_id', 'valueField' => 'jug_id', 'labelField' => 'jug_apellido', 'url' => '/api/jugadores/consulta'])

@endsection