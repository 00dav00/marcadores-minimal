@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Fechas</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('fechas/create') !!}">Agregar una Fecha</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Fase</th>
				<th class="text-center tb-titulo">Número</th>
				<th class="text-center tb-titulo">Fecha de referencia</th>
				<th class="text-center tb-titulo"></th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($fechas as $fecha)
			<tr>
				<td class="text-center">{!! $fecha->fase->fas_descripcion !!}</td>
				<td class="text-center">{!! $fecha->fec_numero !!}</td>
				<td class="text-center">{!! $fecha->fec_fecha_referencia !!}</td>
				<td class="text-center">{!! link_to_route('fechas.show', 'Detalles', [$fecha->fec_id]) !!}</td>
				<td class="text-center">
					{!! link_to_action('PartidoController@index','Partidos',[$fecha->fec_id, ]) !!}
				</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $fechas->render() !!}</h5>

</div>

@endsection