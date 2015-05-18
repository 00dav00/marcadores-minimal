@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de lugares</h2>

	@include('flash::message')

	<h5 class="text-center"><a href="{!! url('lugares/create') !!}">Agregar un Lugar</a></h5>

	@include('partials.searchForm', ['route' => 'lugares'])

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Abreviatura</th>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Tipo</th>
				<th class="text-center tb-titulo">Pertenece a</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($lugares as $lugar)
			<tr>
				<td class="text-center">{!! $lugar->lug_abreviatura !!}</td>
				<td class="text-center">{!! $lugar->lug_nombre !!}</td>
				<td class="text-center">{!! ucfirst($lugar->lug_tipo) !!}</td>
				<td class="text-center">{!! isset($lugar->lugarPadre->lug_nombre) ? $lugar->lugarPadre->lug_nombre : '' !!}</td>
				<td class="text-center">{!! link_to_route('lugares.edit', 'Editar', [$lugar->lug_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $lugares->appends(['keyword' => $keyword, 'column' => $column])->render() !!}</h5>

</div>

@endsection