(function() {
	'use strict';

	angular
		.module('tablasTorneo')
		.controller('goleadoresController', goleadoresController);

function goleadoresController(
	toaster, 
	exception,
	Goleadores
	) 
{

	var tbl = this;

	tbl.init = init;

	function init(idTorneo, idCliente) {
		Goleadores.getGoleadores()
			.get({cliente: idCliente, torneo: idTorneo})
				.$promise.then(
					function(data) {
						obtenerInfoCliente(data.cliente);
						tbl.torneo = data.torneo;
						tbl.posiciones = data.posiciones;
						mostrarFasePosiciones();
					}, function (error) {
						exception.catcher(error);
					}
			);
	}

	function obtenerInfoCliente(cliente) {
		tbl.cliente = cliente;
		
		if (cliente.personalizacion[0]) {
			tbl.containerStyle = {
				"background-color": cliente.personalizacion[0].pva_valor,
				"color": cliente.personalizacion[4].pva_valor
			};

			tbl.headerStyle = {
				"color": cliente.personalizacion[1].pva_valor
			};

			tbl.headerTablaStyle = {
				"background-color": cliente.personalizacion[2].pva_valor,
				"color": cliente.personalizacion[3].pva_valor
			};

			tbl.botonesStyle = {
				"background-color": cliente.personalizacion[5].pva_valor,
				"color": cliente.personalizacion[6].pva_valor,
			};
		}
	}
}

})();