(function() {
	'use strict';

	angular
		.module('resultadosTorneo')
		.controller('resultadosController', resultadosController);

function resultadosController(
	toaster, 
	exception,
	Resultados
	) 
{

	var res = this;

	/**
	 * Funciones
	 */
	res.init = init;

	/**
	 * Obtener los valores para mostrar
	 */
	function init(idTorneo, idCliente) 
	{
		Posiciones.getPosiciones()
			.get({cliente: idCliente, torneo: idTorneo})
				.$promise.then(
					function(data) {
						obtenerInfoCliente(data.cliente);
						res.torneo = data.torneo;
					}, function (error) {
						exception.catcher(error);
					}
			);
	}

	function obtenerInfoCliente(cliente)
	{
		res.cliente = cliente;
		
		if (cliente.personalizacion[0]) {
			res.containerStyle = {
				"background-color": cliente.personalizacion[0].pva_valor,
				"color": cliente.personalizacion[4].pva_valor
			};

			res.headerStyle = {
				"color": cliente.personalizacion[1].pva_valor
			};

			res.headerTablaStyle = {
				"background-color": cliente.personalizacion[2].pva_valor,
				"color": cliente.personalizacion[3].pva_valor
			};

			res.botonesStyle = {
				"background-color": cliente.personalizacion[5].pva_valor,
				"color": cliente.personalizacion[6].pva_valor
			};
		}
	}
	
}

})();