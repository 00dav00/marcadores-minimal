(function() {
    'use strict';

    angular
        .module('wizardTorneo')
        .controller('wizardTorneoController', wizardTorneo);

function wizardTorneo($http, wizardFactory) {
	
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


}
        
})();