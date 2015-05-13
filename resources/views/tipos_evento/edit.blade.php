@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Tipo de Evento</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model(
						$tipoEvento
						,[
							'method' => 'PATCH'
							,'route' => ['tipos_evento.update', $tipoEvento->tev_id]
						]
				) !!}
					@include('tipos_evento.partials._form')
					{!! Form::submit('Actualizar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@endsection