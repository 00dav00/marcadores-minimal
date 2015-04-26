@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar un Equipo</h3>
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

				{!! Form::model($equipo, ['method' => 'PATCH', 'route' => ['equipos.update', $equipo->eqp_id]]) !!}
					@include('equipos.partials._form', ['lug_id' => $equipo->nacionalidad->lug_id, 'lug_nombre' => $equipo->nacionalidad->lug_nombre])
					{!! Form::submit('Editar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function() {
	
	$( "#eqp_fecha_fundacion" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
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
				url: '/lugares/consulta/all',
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