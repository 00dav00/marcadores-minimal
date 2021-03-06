@extends('app')

@section('stylesheets')

<link href="{!! asset('/assets/css/vendor/selectize.css') !!}" rel="stylesheet">
<link href="{!! asset('/assets/css/vendor/jquery-ui/all.css') !!}" rel="stylesheet">
<link href="{!! asset('/assets/css/vendor/jquery-ui-timepicker-addon.min.css') !!}" rel="stylesheet">

@endsection

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Equipo</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model(
					$equipo, 
					[
						'method' => 'PATCH', 
						'route' => ['equipos.update', $equipo->eqp_id],
						'files' => true,
					]
				) !!}
					@include(
						'equipos.partials._form', 
						[
							'lug_id' => $equipo->nacionalidad->lug_id, 
							'lug_nombre' => $equipo->nacionalidad->lug_nombre
						]
					)
					{!! Form::submit('Editar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script src="{!! asset('/assets/js/vendor/selectize.min.js') !!}"></script>

<script src="{!! asset('/assets/js/vendor/jquery-ui.min.js') !!}"></script>
<script src="{!! asset('/assets/js/vendor/jquery-ui-timepicker-addon.min.js') !!}"></script>

@include('partials.selectize', ['id' => '#lug_id', 'valueField' => 'lug_id', 'labelField' => 'lug_nombre', 'extraField' => 'lug_tipo', 'url' => '/api/lugares/consulta/all'])

<script type="text/javascript">
$(function() {
	
	$( "#eqp_fecha_fundacion" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	});

});
</script>

@endsection