@extends('app')

@section('content')

<div class="row centered-form">
	<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de una fase</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<p><mark>Descripción:</mark> {!! $fase->fas_descripcion !!}</p>
				</div>
				<div class="form-group">
					<p><mark>Tipo de fase:</mark> {!! $fase->tipoFase->tfa_nombre !!}</p>
				</div>
				<div class="form-group">
					<p><mark>Torneo:</mark> {!! $fase->torneo->tor_nombre !!}</p>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group text-center">
							{!! Form::open(array('route' => array('fases.edit', $fase->fas_id), 'method' => 'GET')) !!}
							{!! Form::submit('Editar', array('class' => 'btn btn-primary')) !!}
							{!! Form::close() !!}
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group text-center">
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmation" >Delete</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">¿Está seguro que desea borrar?</h4>

			</div>
			<div class="modal-body">
				{!! Form::open(array('route' => array('fases.destroy', $fase->fas_id), 'method' => 'delete', 'class' => 'destroy')) !!}
				{!! Form::submit('Si', array('class' => 'btn btn-success btn-sm')) !!}
				<button type="submit" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
				{!! Form::close() !!}
			</div>

		</div>
	</div>
</div>

@endsection