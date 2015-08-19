(function() {
	'use strict';

	angular
	.module('wizardTorneo')
	.controller('wizardTorneoController', wizardTorneo);

	function wizardTorneo($http, wizardFactory, $modal) {

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

	// agregar una fecha en una fase
	vm.agregarFecha = agregarFecha;

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
		vm.alerts.splice(index, 1);
	}

	// torneos creados
	function getTorneos() {
		wizardFactory.getTorneos()
		.success(function(data) {
			vm.torneos = data;
		})
	}

	// una vez se ha seleccionado un torneo, empieza el wizzard
	function beginWizard() {
		vm.showTorneoInfo = true;
		vm.paso = 2;

		wizardFactory.equiposParticipantes(vm.torneoSelected.tor_id)
		.success(function(data) {
			vm.equiposParticipantes = data;
		}).then(function() {
			wizardFactory.equipos()
			.success(function(data) {
				vm.equipos = data;
			})
		})
	}

	// agregar un equipo participante
	function agregarEquipo() {
		var repetido = false;
		for (var i = 0; i < vm.equiposParticipantes.length; i++) {
			if (vm.equiposParticipantes[i].eqp_id == vm.nuevoEquipo.eqp_id) {
				repetido = true;
				vm.alerts.push(
					{ type: 'danger', msg: vm.nuevoEquipo.eqp_nombre + ' no se pudo agregar' }
					);
				break;
			} 
		}

		if (!repetido) {
			
			var equipo = {
				'tor_id': vm.torneoSelected.tor_id,
				'eqp_id': vm.nuevoEquipo.eqp_id,
			}

			wizardFactory.agregarEquipoParticipante(equipo)
			.success(function() {
				vm.alerts.push(
					{ type: 'success', msg: vm.nuevoEquipo.eqp_nombre + ' fue agregado exitosamente' }
					);
				vm.equiposParticipantes.push(vm.nuevoEquipo);
			})
		}
	}

	// borrar un equipo participante
	function borrarEquipoParticipante(equipo) {
		wizardFactory.borrarEquipoParticipante(vm.torneoSelected.tor_id, equipo.eqp_id)
		.success(function () {
			for (var i = 0; i < vm.equiposParticipantes.length; i++) {
				if (vm.equiposParticipantes[i].eqp_id == equipo.eqp_id) {
					vm.equiposParticipantes.splice(i, 1);
					vm.alerts.push(
						{ type: 'warning', msg: equipo.eqp_nombre + ' fue eliminado' }
						);
					break;
				}
			} 
		});
	}

	function fasesTorneo() {
		vm.paso = 3;

		wizardFactory.tiposFase()
		.success(function (data) {
			vm.tiposFase = data;
			wizardFactory.fases(vm.torneoSelected.tor_id)
			.success(function (data) {
				vm.fases = data;
			})
		})

	}

	function crearFase() {
		vm.nuevaFase.tor_id = vm.torneoSelected.tor_id;
		wizardFactory.crearFase(vm.nuevaFase)
		.success(function () {
			vm.alerts.push(
				{ type: 'success', msg: vm.nuevaFase.fas_descripcion + ' fue agregada exitosamente' }
				);

			vm.nuevaFase = {};

			wizardFactory.fases(vm.torneoSelected.tor_id)
			.success(function (data) {
				vm.fases = data;
			})
		})
	}

	function editarFase(fase) {
		vm.paso = 4;
		vm.faseSelected = fase;

		wizardFactory.fechas(vm.faseSelected.fas_id)
		.success(function (data) {
			vm.fechas = data;
		})
	}

	function borrarFase(fase) {
		
		wizardFactory.deleteFase(fase.fas_id)
		.success(function () {
			vm.alerts.push(
				{ type: 'success', msg: fase.fas_descripcion + ' fue eliminada exitosamente' }
				);
			wizardFactory.fases(vm.torneoSelected.tor_id)
			.success(function (data) {
				vm.fases = data;
			})
		})
		.error(function () {
			vm.alerts.push(
				{ type: 'danger', msg: fase.fas_descripcion + ' no pudo ser eliminada' }
				);
		})

	}

	function agregarFecha() {
		var fecha = {
			fec_numero: vm.fechas.length + 1,
			fas_id: vm.faseSelected.fas_id
		}

		wizardFactory.createFecha(fecha)
		.success(function () {
			wizardFactory.fechas(vm.faseSelected.fas_id)
			.success(function (data) {
				vm.fechas = data;
			})
		})
	}

	function borrarFecha(fecha) {
		wizardFactory.deleteFecha(fecha.fec_id)
		.success(function () {
			wizardFactory.fechas(vm.faseSelected.fas_id)
			.success(function (data) {
				vm.fechas = data;
			})
		})
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
				goles_visitante: "",
				goles_local: "",
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
				if (equipos[j].eqp_id === partidos[i].par_eqp_local) {
					equipos.splice(j, 1);
				} else if (equipos[j].eqp_id === partidos[i].par_eqp_visitante) {
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
			.succes(function () {
				vm.equiposSeleccionables.push(partido.equipo_local);
				vm.equiposSeleccionables.push(partido.equipo_visitante);
				for (var j = 0; j < vm.partidos.length; j++) {
					if (vm.partidos[j].par_id === partido.par_id) {
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

	formatHours(partido.par_hora);

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

	md.partido = partido;
	md.estadios = estadios;

	function formatHours(hour) {
		var res = hour.split(":")
		var d = new Date();
		d.setHours(parseInt(res[0]), parseInt(res[1]));
		partido.par_hora = d;
	}

	md.editar = function() {
		var partido = angular.copy(md.partido);
		delete partido.equipo_local;
		delete partido.equipo_visitante;
		delete partido.estadio;

		wizardFactory.editarPartido(partido)
			.success(function () {
				$modalInstance.close();
			})
	}
}

})();