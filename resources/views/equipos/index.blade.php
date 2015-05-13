@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de Equipos</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('equipos/create') !!}">Agregar un Equipo</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Tipo</th>
				<th class="text-center tb-titulo">Lugar</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($equipos as $equipo)
			<tr>
				<td class="text-center">{!! $equipo->eqp_nombre !!}</td>
				<td class="text-center">{!! ucfirst($equipo->eqp_tipo) !!}</td>
				<td class="text-center">{!! $equipo->nacionalidad->lug_nombre !!}</td>
				<td class="text-center">{!! link_to_route('equipos.show', 'Detalles', [$equipo->eqp_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $equipos->render() !!}</h5>

</div>

@endsection