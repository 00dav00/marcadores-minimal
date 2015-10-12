@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Editar un Jugador</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model($jugador, ['method' => 'PATCH', 'route' => ['jugadores.update', $jugador->jug_id], 'files' => true]) !!}
					@include('jugadores.partials._form', 
						[
							'lug_id' => isset($jugador->nacionalidad->lug_id) ? $jugador->nacionalidad->lug_id : null, 
							'lug_nombre' => isset($jugador->nacionalidad->lug_nombre) ? $jugador->nacionalidad->lug_nombre : null,
						]
					)
					{!! Form::submit('Editar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function() {
	
	$( "#jug_fecha_nacimiento" ).datepicker({
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
				url: '/api/lugares/consulta/pais',
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