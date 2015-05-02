@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Estadio</h3>
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

<script type="text/javascript">
	$(function() {
		
		$( "#est_fecha_inauguracion" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: "c-50:c"
		});

		$('#lug_id').selectize({
			valueField: 'lug_id',
			labelField: 'lug_nombre',
			searchField: ['lug_nombre'],
			render: {
				option: function(item, escape) {
					return '<div> <strong>Nombre:</strong> ' + escape(item.lug_nombre) + ', <strong>Tipo:</strong> ' + escape(item.lug_tipo) + '</div>';
				}
			},
			load: function(query, callback) {
				if (!query.length) return callback();
				$.ajax({
					url: '/lugares/consulta/pais',
					type: 'GET',
					dataType: 'json',
					data: {
						nombre: query
					},
					success: function(res) {
						callback(res.data);
					}
				});
			}
		});

	});
</script>

@endsection