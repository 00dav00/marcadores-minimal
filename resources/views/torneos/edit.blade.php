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
				<h3 class="panel-title">Editar un Torneo</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model($torneo, ['method' => 'PATCH', 'route' => ['torneos.update', $torneo->tor_id]]) !!}
					@include('torneos.partials._form', ['ttr_id' => $torneo->tipoTorneo->ttr_id, 'ttr_nombre' => $torneo->tipoTorneo->ttr_nombre, 'lug_id' => $torneo->lugar->lug_id, 'lug_nombre' => $torneo->lugar->lug_nombre])
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

@include('partials.selectize', ['id' => '#ttr_id', 'valueField' => 'ttr_id', 'labelField' => 'ttr_nombre', 'url' => '/api/tipo_torneo/consulta'])

@include('partials.selectize', ['id' => '#lug_id', 'valueField' => 'lug_id', 'labelField' => 'lug_nombre', 'url' => '/api/lugares/consulta/all'])

<script type="text/javascript">
$(function() {
	
	$( "#tor_fecha_inicio" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	});

	$( "#tor_fecha_fin" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	});

});
</script>

@endsection