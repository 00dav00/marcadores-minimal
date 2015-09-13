(function() {
	'use strict';

	angular
	.module('wizardTorneo')
	.controller('wizardTorneoController', wizardTorneo);

function wizardTorneo($http, wizardFactory, $timeout, $modal) {

	var vm = this;

	vm.equiposParticipantes = [];

	// alertas
	vm.alerts = [];
	vm.closeAlert = closeAlert;

	// empezar el wizard, con el campeonato seleccionado
	vm.beginWizard = beginWizard;

	// agregar un equipo
	vm.agregarEquipo = agregarEquipo;

	// borrar un equipo participante
	vm.borrarEquipoParticipante = borrarEquipoParticipante;

	// menu para administrar las fases de un torneo
	vm.fasesTorneo = fasesTorneo;

	// crear fase de un torneo
	vm.crearFase = crearFase;

	// editar fase de un torneo
	// ver las fechas de un torneo
	vm.editarFase = editarFase;

	// borrar la fase de un torneo
	vm.borrarFase = borrarFase;

	// crear una penalizacion
	vm.nuevaPenalizacion = {};
	vm.crearPenalizacion = crearPenalizacion;
	vm.borrarPenalizacion = borrarPenalizacion;

	// agregar una fecha en una fase
	vm.agregarFecha = agregarFecha;

	// actualizar una fecha del torneo
	vm.actualizarFecha = actualizarFecha;

	// borrar una fecha
	vm.borrarFecha = borrarFecha;

	// editar los partidos de una fecha
	vm.editarFecha = editarFecha;

	// agregar partido
	vm.agregarPartido = agregarPartido;

	vm.regresarFechasFase = regresarFechasFase;

	vm.showAgregarPartido = showAgregarPartido;

	vm.editarPartido = editarPartido;

	vm.borrarPartido = borrarPartido;

	vm.optionsEquipoLocal = {
		accept: function(dragEl) {
			if (vm.nuevoPartido.equipoLocal.length >= 1) {
				return false;
			} else {
				return true;
			}
		}
	};
	vm.optionsEquipoVisitante = {
		accept: function(dragEl) {
			if (vm.nuevoPartido.equipoVisitante.length >= 1) {
				return false;
			} else {
				return true;
			}
		}
	};

	// date picker
	vm.status = {
		opened: false
	};

	vm.dateOptions = {
		startingDay: 1
	};

	vm.open = function($event) {
		vm.status.opened = true;
	};

	// obtener los torneos creados
	getTorneos();

	// cerrar alertas
	function closeAlert(index) {
		if (vm.alerts.length >= (index + 1))
			vm.alerts.splice(index, 1);
	}

	// agregar alerts
	function createAlert(type, message){
		vm.alerts.push({ type: type, msg: message });
		$timeout(function() { 
	 		closeAlert(0);
	 	}, 5000);
	}

	// gestionar errores
	function errorHandler(error, code){
		switch(code){
			case 404:
				console.log("ERROR:" + error);
				createAlert('danger', 'Error: Operación no encontrada.');
				break;
			case 422:
				angular.forEach(error, function(value, key) {
			  		createAlert('danger', 'Error: ' + value);
				});
				break;
			case 500:
				console.log("ERROR:" + error);
				createAlert('danger', 'Error: Operación no permitida.');
				break;
			default:
				alert('Error!');
				console.log("ERROR:" + error);
				break;
		}
	}

	// torneos creados
	function getTorneos() {
		wizardFactory.getTorneos()

			.success(function(data) {
				vm.torneos = data;
			})
			.error( errorHandler );
	}

	// una vez se ha seleccionado un torneo, empieza el wizzard
	function beginWizard() {
		vm.showTorneoInfo = true;
		vm.paso = 2;
		obtenerEquiposParticipantes();
	}

	// obtener equipos participantes del torneo
	function obtenerEquiposParticipantes(){
		wizardFactory.equiposParticipantes(vm.torneoSelected.tor_id)
			.success(function (data) {
				vm.equiposParticipantes = data;
				obtenerEquiposDisponibles();
			})
			.error( errorHandler );
	}

	// obtener equipos ingresados previamente
	function obtenerEquiposDisponibles(){
		wizardFactory.equipos()
			.success(function (data) {
				vm.equipos = data;
			})
			.error( errorHandler );		
	}

	// agregar un equipo participante
	function agregarEquipo() {
		var repetido = false;
		var completos = false;

		for (var i = 0; i < vm.equiposParticipantes.length; i++) {
			if (vm.equiposParticipantes[i].eqp_id == vm.nuevoEquipo.eqp_id) {
				repetido = true;
				createAlert('danger', vm.nuevoEquipo.eqp_nombre + ' no se pudo agregar, equipo ya fue ingresado.');
				break;
			} 
		}

		if (vm.equiposParticipantes.length >= vm.torneoSelected.tor_numero_equipos){
			createAlert('danger', vm.nuevoEquipo.eqp_nombre + ' no se pudo agregar, equipos completos.');
			completos = true;	
		}

		if (!repetido && !completos) {
			
			var equipo = {
				'tor_id': vm.torneoSelected.tor_id,
				'eqp_id': vm.nuevoEquipo.eqp_id,
			}

			wizardFactory.agregarEquipoParticipante(equipo)
				.success(function() {
					createAlert('success', vm.nuevoEquipo.eqp_nombre + ' fue agregado exitosamente');
					vm.equiposParticipantes.push(vm.nuevoEquipo);
				})
				.error( errorHandler );
		}
	}

	// borrar un equipo participante
	function borrarEquipoParticipante(equipo) {
		wizardFactory.borrarEquipoParticipante(vm.torneoSelected.tor_id, equipo.eqp_id)
			.success(function () {
				obtenerEquiposParticipantes();
				createAlert('warning', equipo.eqp_nombre + ' fue retirado del torneo.');
			})
			.error( errorHandler );
	}

	// paso del wizard que maneja las fases
	function fasesTorneo() {
		vm.paso = 3;
		obtenerFases();
		obtenerTiposDeFase();
		obtenerPenalizaciones();
	}

	//obtener tipos de fases disponibles
	function obtenerTiposDeFase(){
		wizardFactory.tiposFase()
		.success(function (data) {
				vm.tiposFase = data;
			})
		.error( errorHandler );			
	}

	// obtener fases del torneo
	function obtenerFases(){
		wizardFactory.fases(vm.torneoSelected.tor_id)
			.success(function (data) {
				vm.fases = data;
			})
		.error( errorHandler );			
	}

	// agregar una fase al torneo
	function crearFase() {
		if (!vm.nuevaFase.fas_acumulada)
			vm.nuevaFase.fas_acumulada = 0;
		vm.nuevaFase.tor_id = vm.torneoSelected.tor_id;

		wizardFactory.crearFase(vm.nuevaFase)
			.success(function () {
				createAlert('success', vm.nuevaFase.fas_descripcion + ' fue agregada exitosamente')				
				vm.nuevaFase = {};
				obtenerFases();
			})
			.error( errorHandler );
	}

	// borrar una fase del torneo
	function borrarFase(fase) {
		wizardFactory.deleteFase(fase.fas_id)
			.success(function () {
				createAlert('warning', fase.fas_descripcion + ' fue eliminada exitosamente');
				obtenerFases();
			})
			.error( errorHandler );
	}

	//paso del wizard encargado de las fechas
	function editarFase(fase) {
		vm.paso = 4;
		vm.faseSelected = fase;
		obtenerFechas();
	}

	function obtenerPenalizaciones() {
		wizardFactory.penalizaciones(vm.torneoSelected.tor_id)
			.success(function (data) {
				vm.penalizaciones = data.data;
			})
			.error( errorHandler );	
	}

	function crearPenalizacion() {
		
		vm.nuevaPenalizacion.tor_id = vm.torneoSelected.tor_id;

		wizardFactory.crearPenalizacion(vm.nuevaPenalizacion)
			.success(function () {
				createAlert('success', 'La penalización fue agregada exitosamente')				
				vm.nuevaPenalizacion = {};
				obtenerPenalizaciones();
			})
			.error( errorHandler );
	}

	function borrarPenalizacion(penalizacion) {
		wizardFactory.borrarPenalizacion(penalizacion.tor_id, penalizacion.fas_id, penalizacion.eqp_id)
			.success(function () {
				createAlert('warning', 'Penalizacion fue eliminada exitosamente');
				obtenerPenalizaciones();
			})
			.error( errorHandler );
	}

	function obtenerFechas(){
		wizardFactory.fechas(vm.faseSelected.fas_id)
			.success(function (data) {
				vm.fechas = data;
			})
			.error( errorHandler );
	}

	function agregarFecha() {
		var fecha = {
			fec_numero: vm.fechas.length + 1,
			fas_id: vm.faseSelected.fas_id,
		}

		wizardFactory.createFecha(fecha)
			.success(function () {
				createAlert('success', 'Fecha '+ fecha.fec_numero + ' del torneo, fue agregada exitosamente');
				obtenerFechas();
			})
			.error( errorHandler );	
	}

	function actualizarFecha(fecha){
		wizardFactory.updateFecha(fecha)
		.success(function () {
				createAlert('success', 'Fecha '+ fecha.fec_numero + ' del torneo, fue actualizada exitosamente');
				obtenerFechas();
			})
			.error( errorHandler );	
	}

	function borrarFecha(fecha) {
		wizardFactory.deleteFecha(fecha.fec_id)
		.success(function () {
				createAlert('warning', 'Fecha '+ fecha.fec_numero + ' del torneo, fue eliminada exitosamente');
				obtenerFechas();
			})
			.error( errorHandler );	
	}

	function editarFecha(fecha) {
		vm.paso = 5;
		vm.fechaSelected = fecha;

		wizardFactory.partidos(vm.fechaSelected.fec_id)
		.success(function (data) {
			vm.partidos = data;
			vm.equiposSeleccionables = angular.copy(vm.equiposParticipantes);
		})
		.then(function () {
			wizardFactory.estadios()
			.success(function (data) {
				vm.estadios = data;
				quitarEquipoSeleccionado(vm.partidos, vm.equiposSeleccionables);
				resetNuevoPartido()
			})
		})
	}

	function agregarPartido() {
		if (vm.nuevoPartido.equipoLocal[0] && vm.nuevoPartido.equipoVisitante[0] && vm.nuevoPartido.par_fecha && vm.nuevoPartido.par_hora) {
			var partido = {
				par_eqp_local: vm.nuevoPartido.equipoLocal[0].eqp_id,
				par_eqp_visitante: vm.nuevoPartido.equipoVisitante[0].eqp_id,
				est_id: vm.nuevoPartido.est_id,
				par_fecha: vm.nuevoPartido.par_fecha,
				par_hora: vm.nuevoPartido.par_hora,
				par_cronica: "",
				fec_id: vm.fechaSelected.fec_id
			};

			wizardFactory.crearPartido(partido)
			.success(function (data) {
				console.log(data);
			})
			.then(function () {
				resetNuevoPartido();
				vm.mostrarAgregarPartido = false;

				wizardFactory.partidos(vm.fechaSelected.fec_id)
				.success(function (data) {
					vm.partidos = data;
				})
			})

		}

	}

	function regresarFechasFase() {
		vm.paso = 4;

		wizardFactory.fechas(vm.faseSelected.fas_id)
		.success(function (data) {
			vm.fechas = data;
		})
	}

	function defaultHour() {
		var d = new Date();
		d.setHours(8);
		d.setMinutes(0);
		vm.nuevoPartido.par_hora = d;
	}

	function defaultDate() {
		vm.nuevoPartido.par_fecha = new Date();
	}

	function quitarEquipoSeleccionado(partidos, equipos) {
		for (var i = 0; i < partidos.length; i++) {
			for (var j = 0; j < equipos.length; j++) {
				if (equipos[j].eqp_id == partidos[i].par_eqp_local) {
					equipos.splice(j, 1);
				} 
			};
		};

		for (var i = 0; i < partidos.length; i++) {
			for (var j = 0; j < equipos.length; j++) {
				if (equipos[j].eqp_id == partidos[i].par_eqp_visitante) {
					equipos.splice(j, 1);
				} 
			};
		};
	}

	function resetNuevoPartido() {
		vm.nuevoPartido = {};
		vm.nuevoPartido.equipoLocal = [];
		vm.nuevoPartido.equipoVisitante = [];
		defaultHour();
		defaultDate();
	}

	function showAgregarPartido() {
		vm.mostrarAgregarPartido = !vm.mostrarAgregarPartido;
	}

	function editarPartido(partido) {

		var modalInstance = $modal.open({
			animation: true,
			templateUrl: 'editarPartido.html',
			controller: 'ModalEditarPartidoCtrl as md',
			size: 'md',
			resolve: {
				partido: function () {
					return partido;
				},
				estadios: function () {
					return vm.estadios;
				}
			}
		});

		modalInstance.result.then(function () {
			wizardFactory.partidos(vm.fechaSelected.fec_id)
				.success(function (data) {
					vm.partidos = data;
				})
		}, function () {
			console.log('Modal dismissed at: ' + new Date());
		});
	}

	function borrarPartido(partido) {
		wizardFactory.borrarPartido(partido.par_id)
			.success(function () {
				vm.equiposSeleccionables.push(partido.equipo_local);
				vm.equiposSeleccionables.push(partido.equipo_visitante);
				for (var j = 0; j < vm.partidos.length; j++) {
					if (vm.partidos[j].par_id == partido.par_id) {
						vm.partidos.splice(j, 1);
						break;
					}
				};
			})
	}

}

})();

(function() {
	'use strict';

	angular
	.module('wizardTorneo')
	.controller('ModalEditarPartidoCtrl', editarPartido);

function editarPartido ($modalInstance, partido, estadios, wizardFactory) {
	var md = this;

	var partidoEdicion = angular.copy(partido);

	if (partidoEdicion.par_hora) {
		formatHours(partidoEdicion.par_hora);
		md.partidoDiferido = false;
	} else {
		md.partidoDiferido = true;
	}

	formatGoles(partido.par_goles_local, partido.par_goles_visitante);

	md.cancel = function () {
    	$modalInstance.dismiss('cancel');
	};

	md.open = function($event) {
    	md.status.opened = true;
	};

	md.status = {
		opened: false
	};

	md.dateOptions = {
		startingDay: 1
	};

	md.partido = partidoEdicion;
	md.estadios = estadios;

	function formatHours(hour) {
		var res = hour.split(":")
		var d = new Date();
		d.setHours(parseInt(res[0]), parseInt(res[1]));
		partidoEdicion.par_hora = d;
	}

	function formatGoles(goles_local, goles_visitante) {
		partidoEdicion.par_goles_local = parseInt(goles_local);
		partidoEdicion.par_goles_visitante = parseInt(goles_visitante);
	}

	md.editar = function() {
		var partido = angular.copy(md.partido);
		delete partido.equipo_local;
		delete partido.equipo_visitante;
		delete partido.estadio;

		if (md.partidoDiferido) {
			partido.par_fecha = null;
			partido.par_hora = null;
		}

		console.log(partido);

		wizardFactory.editarPartido(partido)
			.success(function () {
				$modalInstance.close();
			})
	}
}

})();