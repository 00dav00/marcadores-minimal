@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Partido nuevo</h3>
			</div>
			<div class="panel-body">
				
				@include('partials.validation_errors')

				{!! Form::model(
					$partido,
					array(
						'method' => 'PATCH',
						'action' => array(
							'PartidoController@update', 
							$partido->fecha->fec_id, 
							$partido->par_id
						)
					))
				!!}

					<?php
						$equipos = [];
						
						foreach($partido->fecha->fase->torneo->equiposParticipantes as $equipo){
							$equipos[$equipo->eqp_id] = $equipo->eqp_nombre;
						}
					?>

					@include(
						'partidos.partials._form',
						[
							'torneo' => $partido->fecha->fase->torneo->tor_nombre,
							'fase' => $partido->fecha->fase->tipoFase->tfa_nombre,
							'numero' => $partido->fecha->fec_numero,
							'equipos' => $equipos,
							'par_eqp_local' => $partido->par_eqp_local,
							'par_eqp_visitante' => $partido->par_eqp_visitante,
							'est_id' => $partido->est_id,
							'est_nombre' => $partido->estadio->est_nombre

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

	$('#est_id').selectize({
		valueField: 'est_id',
		labelField: 'est_nombre',
		searchField: ['est_nombre'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.est_nombre) + '</div>';
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '/estadios/consulta',
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

	$( "#par_fecha" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	});

	$( "#par_hora" ).timepicker({
		controlType: 'select',
		oneLine: true,
		pmNames: false,
		timeFormat: 'HH:mm',
		hour: 11,
		minute: 30,
	});
	
});
</script>

@endsection
