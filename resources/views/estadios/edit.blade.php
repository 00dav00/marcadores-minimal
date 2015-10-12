@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Estadio</h3>
			</div>

			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model(
					$estadio
					,[
						'method' => 'PATCH'
						,'route' => ['estadios.update', $estadio->est_id]
						,'files' => true
					]) 
				!!}

					@include(
						'estadios.partials._form'
						,[
							'lug_id' => $estadio->ubicacion->lug_id
							,'lug_nombre' => $estadio->ubicacion->lug_nombre
						]
					)
					{!! Form::submit('Actualizar', array('class'=>'btn btn-info btn-block')) !!}

				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

@include('partials.selectize', ['id' => '#lug_id', 'valueField' => 'lug_id', 'labelField' => 'lug_nombre', 'url' => '/api/lugares/consulta/all'])

<script type="text/javascript">
	$(function() {
		
		$( "#est_fecha_inauguracion" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: "c-50:c"
		});

	});
</script>

@endsection