@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de Jugadores</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('jugadores/create') !!}">Agregar un Jugador</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Apellido</th>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Apodo</th>
				<th class="text-center tb-titulo">Nacionalidad</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($jugadores as $jugador)
			<tr>
				<td class="text-center">{!! $jugador->jug_apellido !!}</td>
				<td class="text-center">{!! $jugador->jug_nombre !!}</td>
				<td class="text-center">{!! $jugador->jug_apodo !!}</td>
				<td class="text-center">{!! $jugador->nacionalidad->lug_nombre !!}</td>
				<td class="text-center">{!! link_to_route('jugadores.show', 'Detalles', [$jugador->jug_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $jugadores->render() !!}</h5>

</div>

@endsection