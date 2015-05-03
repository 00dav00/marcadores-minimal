@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Tipo de torneos</h2>

	@include('flash::message')

	<h5 class="text-center"><a href="{!! url('tipo_torneo/create') !!}">Agregar un Tipo de torneo</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Descripción</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($tipo_torneo as $tipo)
			<tr>
				<td class="text-center">{!! $tipo->ttr_nombre !!}</td>
				<td class="text-center">{!! $tipo->ttr_descripcion !!}</td>
				<td class="text-center">{!! link_to_route('tipo_torneo.show', 'Detalles', [$tipo->ttr_codigo]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $tipo_torneo->render() !!}</h5>

</div>

@endsection