(function() {
	'use strict';

	angular
		.module('wizardCliente')
		.controller('mainController', mainController);

function mainController(
	$http, $timeout, $modal, usSpinnerService, 
	toaster, exception, Clientes, 
	Torneos, Productos, Campos, 
	Tablas
	) 
{

	var main = this;

	main.mostrarTorneos = false;
	main.mostrarProductos = false;
	main.mostrarCampos = false;
	main.spinneractive = false;

	main.cargarTorneos = cargarTorneos;
	main.cargarProductos = cargarProductos;
	main.cargarCampos = cargarCampos;
	main.saveColores = saveColores;

	cargarClientes();

	function cargarClientes()
	{
		usSpinnerService.spin('spinner-1');
		Clientes.getClientes().query().$promise.then(
			function(data) {
				main.clientes = data;
				usSpinnerService.stop('spinner-1');
			}, function (error) {
				exception.catcher(error);
			}
		);
	}

	function cargarTorneos()
	{
		usSpinnerService.spin('spinner-1');
		Torneos.getTorneos().query().$promise.then(
			function(data) {
				main.torneos = data;
				main.mostrarTorneos = true;
				usSpinnerService.stop('spinner-1');
			}, function (error) {
				exception.catcher(error);
			}
		);
	}

	function cargarProductos()
	{
		usSpinnerService.spin('spinner-1');
		Productos.getProductos().query().$promise.then(
			function(data) {
				main.productos = data;
				main.mostrarProductos = true;
				usSpinnerService.stop('spinner-1');
			}, function (error) {
				exception.catcher(error);
			}
		);
	}

	function cargarCampos()
	{
		usSpinnerService.spin('spinner-1');
		Campos.getCampos().query().$promise.then(
			function(data) {
				main.campos = data;
			}, function (error) {
				exception.catcher(error);
			}
		);

		switch (main.productoSeleccionado.prd_nombre) {
			case 'tabla_posiciones':
				Tablas.getTablas()
					.query({ cliente_id: main.clienteSeleccionado.clt_id, torneo_id: main.torneoSeleccionado.tor_id })
					.$promise.then(
						function(data) {
							main.tablas = data;
							compareColours();
							main.mostrarCampos = true;
							usSpinnerService.stop('spinner-1');
						}, function (error) {
							exception.catcher(error);
						}
					);
				break;
		}
	}

	function compareColours()
	{
		angular.forEach(main.campos, function(campo) {
			angular.forEach(main.tablas.cliente.personalizacion, function(valor) {
				if (campo.id == valor.pca_id) {
					campo.valor_default = valor.pva_valor;
				}
			});
		});
	}

	function saveColores()
	{
		console.log(main.campos);
	}

}

})();