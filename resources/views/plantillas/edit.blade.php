@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Editar un Jugador a una Plantilla</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model($plantilla, ['method' => 'PATCH', 'route' => ['plantillas.update', $plantilla->jug_id]]) !!}
					@include('plantillas.partials._form', ['tor_id' => $plantilla->torneo->tor_id, 'tor_nombre' => $plantilla->torneo->tor_nombre, 'eqp_id' => $plantilla->eqp_id, 'eqp_nombre' => $plantilla->equipo->eqp_nombre, 'jug_id' => $plantilla->jug_id, 'jug_nombre' => $plantilla->jugador->jug_nombre])
					{!! Form::submit('Editar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function() {

	$('#tor_id').selectize({
		valueField: 'tor_id',
		labelField: 'tor_nombre',
		searchField: ['tor_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.tor_nombre) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/torneos/consulta',
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

	$('#eqp_id').selectize({
		valueField: 'eqp_id',
		labelField: 'eqp_nombre',
		searchField: ['eqp_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.eqp_nombre) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/equipos/consulta',
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

	$('#jug_id').selectize({
		valueField: 'jug_id',
		labelField: 'jug_apellido',
		searchField: ['jug_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.jug_nombre) + ' <strong>Apellido:</strong> ' + escape(item.jug_apellido) + ' <strong>Apodo:</strong> ' + escape(item.jug_apodo) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/jugadores/consulta',
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