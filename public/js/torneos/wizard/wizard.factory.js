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
		crearFase: crearFase,
		deleteFase: deleteFase,
		crearPenalizacion: crearPenalizacion,
		borrarPenalizacion: borrarPenalizacion,
		fechas: fechas,
		createFecha: createFecha,
		penalizaciones: penalizaciones,
		updateFecha: updateFecha,
		deleteFecha: deleteFecha,
		partidos: partidos,
		estadios: estadios,
		crearPartido: crearPartido,
		borrarPartido: borrarPartido,
		editarPartido: editarPartido
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

	function deleteFase(fas_id) {
		if (fas_id) {
			return $http.delete("/api/fases/" + fas_id)
		}
	}

	function crearPenalizacion(penalizacion) {
		if (penalizacion) {
			return $http.post("/api/penalizaciones", penalizacion);
		}
	}

	function penalizaciones(tor_id) {
		if (tor_id) {
			return $http.get("/api/torneos/" + tor_id + "/penalizaciones");
		}
	}

	function borrarPenalizacion(ptr_id) {
		if (tor_id && fas_id && eqp_id) {
			return $http.delete("/api/penalizaciones/" + ptr_id);
		}
	}

	function fechas(fas_id) {
		if(fas_id) {
			return $http.get("/api/fases/" + fas_id + "/fechas");
		}
	}

	function createFecha(fecha) {
		if (fecha) {
			return $http.post("/api/fechas", fecha);
		}
	}

	function updateFecha(fecha) {
		if (fecha) {
			return $http.put("/api/fechas/"+fecha.fec_id, fecha);
		}
	}

	function deleteFecha(fec_id) {
		if (fec_id) {
			return $http.delete("/api/fechas/" + fec_id);
		}
	}

	function partidos(fec_id) {
		if (fec_id) {
			return $http.get("/api/partidos/" + fec_id);
		}
	}

	function estadios() {
		return $http.get("/api/estadios");
	}

	function crearPartido(partido) {
		return $http.post("/api/partidos", partido);
	}

	function borrarPartido(partido) {
		return $http.delete("/api/partidos/" + partido);
	}

	function editarPartido(partido) {
		return $http.put("/api/partidos/" + partido.par_id, partido);
	}

}
        
})();