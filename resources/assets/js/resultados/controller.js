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
	res.cambiarFecha = cambiarFecha;

	/**
	 * Obtener los valores para mostrar
	 */
	function init(idTorneo, idCliente) 
	{
		Resultados.getInformacionUltimaFecha()
			.get({cliente: idCliente, torneo: idTorneo})
				.$promise.then(
					function(data) {
						obtenerInfoCliente(data.cliente);
						res.fase = data.fase;
						res.torneo = data.torneo;
						res.proximas = data.proximas;
						res.fecha = data.fecha;
						obtenerEquipos(data.torneo.equipos_participantes);
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

	function obtenerEquipos(equipos)
	{
		var resultados = [];
		angular.forEach(equipos, function(value, key) {
		 	resultados[value.eqp_id] = value;
		});
		res.equipos = resultados;
	}

	function cambiarFecha(fecha)
	{
		Resultados.getInformacionFecha()
			.get({
					cliente: res.cliente.clt_id, 
					torneo: res.torneo.tor_id,
					fase: res.fase.fas_id,
					fecha: fecha
				}) .$promise.then(function(data) {
					res.proximas = data.proximas;
					res.fecha = data.fecha;
				}, function (error) {
					exception.catcher(error);
				}
			);
	}
	
}

})();