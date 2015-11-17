@extends('angular')

@section('content')

<div ng-app="wizardCliente" ng-controller="mainController as main">

	<toaster-container></toaster-container>

	<span us-spinner="{lines:15, radius:15, width:5, length: 10, position:absolute, top:'50%', left:'50%'}" spinner-key="spinner-1"></span>

	<div class="col-xs-12">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title text-center">Wizard para configurar clientes</div>
			</div>

			<div class="panel-body">

				<select class="form-control" id="clienteSeleccionado" ng-model="main.clienteSeleccionado" ng-options="cliente.clt_nombre for cliente in main.clientes" ng-change="main.cargarTorneos()">
					<option value="" disabled>Seleccione un Cliente ...</option>
				</select>

				<br>

				<div ng-show="main.mostrarTorneos">
					<select class="form-control" id="torneoSeleccionado" ng-model="main.torneoSeleccionado" ng-options="torneo.tor_nombre for torneo in main.torneos" ng-change="main.cargarProductos()">
						<option value="" disabled>Seleccione un Torneo ...</option>
					</select>
				</div>

				<br>

				<div ng-show="main.mostrarProductos">
					<select class="form-control" id="productoSeleccionado" ng-model="main.productoSeleccionado" ng-options="producto.prd_descripcion for producto in main.productos" ng-change="main.cargarCampos()">
						<option value="" disabled>Seleccione un Producto ...</option>
					</select>
				</div>

				<br>

				<div ng-show="main.mostrarCampos">
					
					@include('clientes.partials._campos')

					<div class="col-xs-8" ng-switch on="main.productoSeleccionado.prd_nombre">
						<div ng-switch-when="tabla_posiciones">
							@include('clientes.partials._tablas')
						</div>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>

@endsection

@section('scripts')

<script src="{!! asset('/js/clientes/wizard/wizard.js') !!}"></script>
<script src="{!! asset('/js/clientes/wizard/config.js') !!}"></script>
<script src="{!! asset('/js/clientes/wizard/exceptionHandler.js') !!}"></script>

<script src="{!! asset('/js/clientes/wizard/controllers/mainController.js') !!}"></script>

<script src="{!! asset('/js/clientes/wizard/factories/clientesFactory.js') !!}"></script>
<script src="{!! asset('/js/clientes/wizard/factories/productosFactory.js') !!}"></script>
<script src="{!! asset('/js/clientes/wizard/factories/camposFactory.js') !!}"></script>
<script src="{!! asset('/js/clientes/wizard/factories/torneosFactory.js') !!}"></script>
<script src="{!! asset('/js/clientes/wizard/factories/tablasFactory.js') !!}"></script>

@endsection
