@extends('app')

@section('stylesheets')

<link href="{!! asset('/assets/css/vendor/selectize.css') !!}" rel="stylesheet">

@endsection

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Lugar</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::open(array('route' => 'lugares.store')) !!}
					@include('lugares.partials._form')
					{!! Form::submit('Agregar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script src="{!! asset('/assets/js/vendor/selectize.min.js') !!}"></script>

@include('partials.selectize', ['id' => '#parent_lug_id', 'valueField' => 'lug_id', 'labelField' => 'lug_nombre', 'url' => '/api/lugares/consulta/all'])

@endsection