@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de equipos y torneos</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('equipos_participantes/create') !!}">Agregar un equipo a un torneo</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Equipo</th>
				<th class="text-center tb-titulo">Torneo</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($equipos as $equipo)
			<tr>
				<td class="text-center">{!! $equipo->equipo->eqp_nombre !!}</td>
				<td class="text-center">{!! $equipo->torneo->tor_nombre!!}</td>
				<td class="text-center">{!! link_to_route('equipos_participantes.show', 'Detalles', [$equipo->eqp_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $equipos->render() !!}</h5>

</div>

@endsection