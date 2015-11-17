(function() {
	'use strict';

	angular
		.module('wizardCliente')
		.controller('mainController', mainController);

function mainController($http, $timeout, $modal, usSpinnerService, toaster, exception, Clientes, Productos, Campos) {

	var main = this;

	main.mostrarProductos = false;
	main.mostrarCampos = false;
	main.spinneractive = false;

	main.cargarProductos = cargarProductos;
	main.cargarCampos = cargarCampos;
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
				main.mostrarCampos = true;
				usSpinnerService.stop('spinner-1');
			}, function (error) {
				exception.catcher(error);
			}
		);
	}

}

})();