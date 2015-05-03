@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de plantillas</h2>

	@include('flash::message')

	<h5 class="text-center"><a href="{!! url('plantillas/create') !!}">Agregar un jugador a una Plantilla</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Equipo</th>
				<th class="text-center tb-titulo">Jugador</th>
				<th class="text-center tb-titulo">Torneo</th>
				<th class="text-center tb-titulo">Número de camiseta</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($plantillas as $plantilla)
			<tr>
				<td class="text-center">{!! $plantilla->equipo->eqp_nombre !!}</td>
				<td class="text-center">{!! $plantilla->jugador->jug_apellido!!} {!! $plantilla->jugador->jug_nombre!!}</td>
				<td class="text-center">{!! $plantilla->torneo->tor_nombre !!}</td>
				<td class="text-center">{!! $plantilla->plt_numero_camiseta !!}</td>
				<td class="text-center">{!! link_to_route('plantillas.show', 'Detalles', [$plantilla->jugador->jug_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $plantillas->render() !!}</h5>

</div>

@endsection