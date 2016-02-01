@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Lista de Clientes</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('clientes/create') !!}">Agregar un Cliente</a></h5>

	@include('partials.searchForm', ['route' => 'clientes'])
	
	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Descripción</th>
				<th class="text-center tb-titulo">Dominio</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($clientes as $cliente)
			<tr>
				<td class="text-center">{!! $cliente->clt_nombre !!}</td>
				<td class="text-center">{!! $cliente->clt_descripcion !!}</td>
				<td class="text-center">{!! $cliente->clt_dominio !!}</td>
				<td class="text-center">{!! link_to_route('clientes.show', 'Detalles', [$cliente->clt_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $clientes->appends(['keyword' => $keyword, 'column' => $column])->render() !!}</h5>	
</div>

@endsection