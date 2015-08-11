(function() {
    'use strict';

    angular
        .module('wizardTorneo')
        .controller('wizardTorneoController', wizardTorneo);

function wizardTorneo($http, wizardFactory, $timeout) {
	
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
				createAlert('warning', equipo.eqp_nombre + ' fue eliminado');
			})
			.error( errorHandler );
	}

	// paso del wizard que maneja las fases
	function fasesTorneo() {
		vm.paso = 3;
		obtenerFases();
		obtenerTiposDeFase();
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

	function borrarFecha(fecha) {
		wizardFactory.deleteFecha(fecha.fec_id)
			.success(function () {
				createAlert('warning', 'Fecha '+ fecha.fec_numero + ' del torneo, fue eliminada exitosamente');
				obtenerFechas();
				// wizardFactory.fechas(vm.faseSelected.fas_id)
				// 	.success(function (data) {
				// 		vm.fechas = data;
				// 	})
			})
			.error( errorHandler );	
	}


}
        
})();