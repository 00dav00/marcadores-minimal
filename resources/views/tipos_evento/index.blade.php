@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Tipos de eventos</h2>

	@include('flash::message')

	<h5 class="text-center">
		<a href="{!! url('tipos_evento/create') !!}">Agregar un Tipo de evento</a>
	</h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Descripción</th>
				<th class="text-center tb-titulo">Comentario Op1</th>
				<th class="text-center tb-titulo">Comentario Op2</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($tiposEvento as $tipo)

			<tr>
				<td class="text-center">{!! $tipo->tev_nombre !!}</td>
				<td class="text-center">{!! $tipo->tev_descripcion !!}</td>
				<td class="text-center">{!! $tipo->tev_comentario1 !!}</td>
				<td class="text-center">{!! $tipo->tev_comentario2 !!}</td>
				<td class="text-center">{!! link_to_route('tipos_evento.show', 'Detalles', [$tipo->tev_id]) !!}</td>
			</tr>

			@endforeach
		</tbody>
	</table>

	<h5 class="text-center">{!! $tiposEvento->render() !!}</h5>
	
</div>

@endsection

