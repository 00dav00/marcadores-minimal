@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de torneos</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('torneos/create') !!}">Agregar un torneo</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Tipo de torneo</th>
				<th class="text-center tb-titulo">Fecha de inicio</th>
				<th class="text-center tb-titulo">Fecha de fin</th>
				<th class="text-center tb-titulo"># Equipos</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($torneos as $torneo)
			<tr>
				<td class="text-center">{!! $torneo->tor_nombre !!}</td>
				<td class="text-center">{!! $torneo->tipoTorneo->ttr_nombre !!}</td>
				<td class="text-center">{!! $torneo->tor_fecha_inicio !!}</td>
				<td class="text-center">{!! $torneo->tor_fecha_fin !!}</td>
				<td class="text-center">{!! $torneo->tor_numero_equipos !!}</td>
				<td class="text-center">
					{!! link_to_route('torneos.show', 'Detalles', [$torneo->tor_id]) !!}
				</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $torneos->render() !!}</h5>

</div>

@endsection