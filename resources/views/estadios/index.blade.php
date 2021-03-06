@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de Estadios</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('estadios/create') !!}">Agregar un estadio</a></h5>

	@include('partials.searchForm', ['route' => 'estadios'])

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Fecha Inauguración</th>
				<th class="text-center tb-titulo">Aforo</th>
				<th class="text-center tb-titulo">Ubicación</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($estadios as $estadio)
			<tr>
				<td class="text-center">{!! $estadio->est_nombre !!}</td>
				<td class="text-center">{!! $estadio->est_fecha_inauguracion !!}</td>
				<td class="text-center">{!! $estadio->est_aforo !!}</td>
				<td class="text-center">{!! $estadio->ubicacion->lug_nombre !!}</td>
				<td class="text-center">{!! link_to_route('estadios.show', 'Detalles', [$estadio->est_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $estadios->appends(['keyword' => $keyword, 'column' => $column])->render() !!}</h5>

</div>

@endsection