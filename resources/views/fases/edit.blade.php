@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Editar una fase</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model($fase, ['method' => 'PATCH', 'route' => ['fases.update', $fase->fas_id]]) !!}
					@include(
						'fases.partials._form', 
						[
							'tor_id' => $fase->torneo->tor_id, 
							'tor_nombre' => $fase->torneo->tor_nombre, 
							'tfa_id' => $fase->tipoFase->tfa_id, 
							'tfa_nombre' => $fase->tipoFase->tfa_nombre
						]
					)
					{!! Form::submit('Editar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@include('partials.selectize', ['id' => '#tfa_id', 'valueField' => 'tfa_id', 'labelField' => 'tfa_nombre', 'url' => '/api/tipo_fase/consulta'])

@include('partials.selectize', ['id' => '#tor_id', 'valueField' => 'tor_id', 'labelField' => 'tor_nombre', 'url' => '/api/torneos/consulta'])

@endsection