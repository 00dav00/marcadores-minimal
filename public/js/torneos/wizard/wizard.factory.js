(function() {
    'use strict';

    angular
        .module('wizardTorneo')
        .factory('wizardFactory', wizardFactory);

function wizardFactory($http) {
	return {
		getTorneos: getTorneos,
		equipos: equipos,
		equiposParticipantes: equiposParticipantes,
		agregarEquipoParticipante: agregarEquipoParticipante,
		borrarEquipoParticipante: borrarEquipoParticipante,
		tiposFase: tiposFase,
		fases: fases,
		crearFase: crearFase
	}

	function getTorneos() {
		return $http.get('/api/torneos');
	}

	function equipos() {
		return $http.get("/api/equipos");
	}

	function equiposParticipantes(tor_id)	{
		return $http.get("/api/torneos/" + tor_id + "/equipos");
	}

	function agregarEquipoParticipante(equipo) {
		if (equipo) {
			return $http.post("/api/equipos_participantes/", equipo);
		}
	}

	function borrarEquipoParticipante(tor_id, eqp_id) {
		if (tor_id && eqp_id) {
			return $http.delete("/api/torneos/" + tor_id + "/equipos/" + eqp_id);
		}
	}

	function tiposFase() {
		return $http.get('/api/tipo_fase');
	}

	function fases(tor_id) {
		if(tor_id) {
			return $http.get("/api/torneos/" + tor_id + "/fases");
		}
	}

	function crearFase(fase) {
		if(fase) {
			return $http.post("/api/fases", fase);
		}
	}

}
        
})();