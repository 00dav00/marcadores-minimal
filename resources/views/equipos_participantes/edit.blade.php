@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Editar un equipo y un torneo</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model($equipo, ['method' => 'PATCH', 'route' => ['equipos_participantes.update', $equipo->eqp_id]]) !!}
					@include('equipos_participantes.partials._form', ['tor_id' => $equipo->torneo->tor_id, 'tor_nombre' => $equipo->torneo->tor_nombre, 'eqp_id' => $equipo->eqp_id, 'eqp_nombre' => $equipo->equipo->eqp_nombre])
					{!! Form::submit('Editar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@include('partials.selectize', ['id' => '#tor_id', 'valueField' => 'tor_id', 'labelField' => 'tor_nombre', 'url' => '/api/torneos/consulta'])

@include('partials.selectize', ['id' => '#eqp_id', 'valueField' => 'eqp_id', 'labelField' => 'eqp_nombre', 'url' => '/api/equipos/consulta'])

@endsection