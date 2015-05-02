@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Agregar una Fase</h3>
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

				{!! Form::open(array('route' => 'fases.store')) !!}
					@include('fases.partials._form')
					{!! Form::submit('Agregar', array('class'=>'btn btn-info btn-block')) !!}
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function() {

	$('#tfa_codigo').selectize({
		valueField: 'tfa_codigo',
		labelField: 'tfa_nombre',
		searchField: ['tfa_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.tfa_nombre) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/tipo_fase/consulta',
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

});
</script>

@endsection