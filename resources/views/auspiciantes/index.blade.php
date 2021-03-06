@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de Auspiciantes</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('auspiciantes/create') !!}">Agregar un Auspiciante</a></h5>

	@include('partials.searchForm', ['route' => 'auspiciantes'])
	
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Sitio Web</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($auspiciantes as $auspiciante)
			<tr>
				<td class="text-center">{!! $auspiciante->aus_nombre !!}</td>
				<td class="text-center">{!! $auspiciante->aus_sitioweb !!}</td>
				<td class="text-center">{!! link_to_route('auspiciantes.show', 'Detalles', [$auspiciante->aus_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $auspiciantes->appends(['keyword' => $keyword, 'column' => $column])->render() !!}</h5>	
</div>

@endsection