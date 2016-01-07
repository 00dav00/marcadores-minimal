(function() {
	'use strict';

	angular
		.module('tablasTorneo')
		.controller('tablasController', tablasController);

function tablasController(
	usSpinnerService, 
	toaster, 
	exception,
	Posiciones
	) 
{

	var tbl = this;

	/**
	 * Funciones
	 */
	tbl.init = init;
	tbl.mostrarFasePosiciones = mostrarFasePosiciones;

	/**
	 * Obtener los valores para mostrar
	 */
	function init(idTorneo, idCliente) 
	{
		usSpinnerService.spin('spinner-1');
		Posiciones.getPosiciones()
			.get({cliente: idCliente, torneo: idTorneo})
				.$promise.then(
					function(data) {
						tbl.cliente = data.cliente;
						tbl.torneo = data.torneo;
						obtenerInfoFases(data.fases);
						tbl.posiciones = data.posiciones;
						mostrarFasePosiciones();
						usSpinnerService.stop('spinner-1');
					}, function (error) {
						exception.catcher(error);
					}
			);
	}

	/**
	 * Funcion para obtener informacion de las fases
	 * y la ultima fase creada
	 */
	function obtenerInfoFases(fases)
	{
		tbl.fases = fases;

		var len = 0;
		angular.forEach(fases, function(valor, campo) {
			len++;
		});
		
		tbl.faseActual = fases[len - 1].fas_id;
	}

	/**
	 * Seleccionar las posiciones de que fase se van a mostrar
	 */
	function mostrarFasePosiciones()
	{
		tbl.equipos = tbl.posiciones[tbl.faseActual];
	}
	
}

})();