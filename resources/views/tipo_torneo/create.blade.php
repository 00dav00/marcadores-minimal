@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Tipo de Torneo</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::open(array('route' => 'tipo_torneo.store')) !!}
					@include('tipo_torneo.partials._form')
					{!! Form::submit('Agregar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@endsection