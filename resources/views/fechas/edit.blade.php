@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Editar una fecha</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model($fecha, ['method' => 'PATCH', 'route' => ['fechas.update', $fecha->fec_id]]) !!}
					@include('fechas.partials._form', ['fas_id' => $fecha->fase->fas_id, 'fas_descripcion' => $fecha->fase->fas_descripcion])
					{!! Form::submit('Editar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@include('partials.selectize', ['id' => '#fas_id', 'valueField' => 'fas_id', 'labelField' => 'fas_descripcion', 'url' => '/api/fases/consulta'])

<script type="text/javascript">
$(function() {

	$( "#fec_fecha_referencia" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	});

});
</script>

@endsection