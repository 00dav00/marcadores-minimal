@extends('app')

@section('content')

<div class="col-md-8 col-md-offset-2">
	<h2 class="text-center">Tipo de fases</h2>
	<h5 class="text-center"><a href="{!! url('tipo_fase/create') !!}">Agregar un Tipo de fase</a></h5>

	<table class="table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th class="text-center tb-titulo">Nombre</th>
				<th class="text-center tb-titulo">Descripción</th>
				<th class="text-center tb-titulo"></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($tipo_fase as $tipo)
			<tr>
				<td class="text-center">{!! $tipo->tfa_nombre !!}</td>
				<td class="text-center">{!! $tipo->tfa_descripcion !!}</td>
				<td class="text-center">{!! link_to_route('tipo_fase.show', 'Detalles', [$tipo->tfa_codigo]) !!}</td>
			</tr>
			@endforeach
		</tbody>

	</table> 

	<h5 class="text-center">{!! $tipo_fase->render() !!}</h5>

</div>

@endsection