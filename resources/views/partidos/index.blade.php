@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de Partidos</h2>

	@include('flash::message')

	<h5 class="text-center">
		<a href="{!! url('fechas/'.$fecha->fec_id.'/partidos/create') !!}">
			Agregar un Partido a la Fecha
		</a>
	</h5>

	<div class="form-group">
		<p><mark>Torneo:</mark> {!! $fecha->fase->torneo->tor_nombre !!}</p>
	</div>
	<div class="form-group">
		<p><mark>Fase:</mark> {!! $fecha->fase->tipoFase->tfa_nombre !!}</p>
	</div>
	<div class="form-group">
		<p><mark>Fecha:</mark> {!! $fecha->fec_numero !!}</p>
	</div>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Local</th>
				<th class="text-center tb-titulo">Visitante</th>
				<th class="text-center tb-titulo">Estadio</th>
				<th class="text-center tb-titulo">Fecha</th>
				<th class="text-center tb-titulo">Hora</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($partidos as $partido)
			<tr>
				<td class="text-center">{!! $partido->equipoLocal->eqp_nombre !!}</td>
				<td class="text-center">{!! $partido->equipoVisitante->eqp_nombre !!}</td>
				<td class="text-center">{!! $partido->estadio->est_nombre !!}</td>
				<td class="text-center">{!! $partido->par_fecha !!}</td>
				<td class="text-center">{!! $partido->par_hora !!}</td>
				<td class="text-center">
					{!! link_to_action('PartidoController@show','Detalles',[$partido->fec_id, $partido->par_id]) !!}
				</td>
			</tr>
			@endforeach
		</tbody>

	</table> 
	
	<h5 class="text-center">{!! $partidos->render() !!}</h5>

</div>

@endsection
