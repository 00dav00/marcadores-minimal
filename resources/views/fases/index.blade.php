@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Fases</h2>

	@include('flash::message')
	
	<h5 class="text-center"><a href="{!! url('fases/create') !!}">Agregar una Fase</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Tipo de fase</th>
				<th class="text-center tb-titulo">Descripción</th>
				<th class="text-center tb-titulo">Torneo</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($fases as $fase)
			<tr>
				<td class="text-center">{!! $fase->tipoFase->tfa_nombre !!}</td>
				<td class="text-center">{!! $fase->fas_descripcion !!}</td>
				<td class="text-center">{!! $fase->torneo->tor_nombre !!}</td>
				<td class="text-center">{!! link_to_route('fases.show', 'Detalles', [$fase->fas_id]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $fases->render() !!}</h5>

</div>

@endsection