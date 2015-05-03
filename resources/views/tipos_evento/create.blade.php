@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Tipo de Evento</h3>
			</div>
			<div class="panel-body">
				@if(Session::get('errors'))
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5>Se produjeron los siguientes errores:</h5>
					@foreach($errors->all('<li>:message</li>') as $message)
					{!! $message !!}
					@endforeach
				</div>
				@endif

				{!! Form::open(array('route' => 'tipos_evento.store')) !!}
					@include('tipos_evento.partials._form')
					{!! Form::submit('Agregar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>


@endsection