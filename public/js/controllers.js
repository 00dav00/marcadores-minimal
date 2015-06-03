'use strict';

/* Controllers */

var plantillaControllers = angular.module('plantillaControllers', []);


plantillaControllers.controller('PlantillasCtrl', ['$scope','EquiposParticipantes','JugadoresInscritos','Plantillas',

	function($scope, EquiposParticipantes, JugadoresInscritos, Plantillas) {
 
 		$scope.loading = false;
		$scope.equipos = [];
		$scope.jugadores = [];
		$scope.torneoSeleccionado = false;
		$scope.equipoSeleccionado = false;
		$scope.equipoNombre = "";
	 	
		$scope.colocarEquipoNombre = function(equipoNombre){
			$scope.equipoNombre = equipoNombre;	
		}

	 	//********Carga los equipos en base al id del Torneo seleccionado***********
		$scope.obtenerEquipos = function(torneo_id) {
			EquiposParticipantes.get(
	            {torneo: torneo_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.equipos = response;
	                $scope.torneoSeleccionado = torneo_id;
	                $scope.jugadores = [];
	                $scope.equipoSeleccionado = false;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

		//********Carga los jugadores del equipo y el torneo seleccionado***********
		$scope.obtenerJugadores = function(equipo_id) {
			$scope.loading = true;

			JugadoresInscritos.get(
	            {torneo: $scope.torneoSeleccionado, equipo: equipo_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.jugadores = response;
	                $scope.equipoSeleccionado = equipo_id;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

		//********Agrega un jugador a la plantilla del equipo y el torneo seleccionado***********
		$scope.ingresarJugadorEnPlantilla = function (jugador_id){

			var plantilla = {
				'tor_id': $scope.torneoSeleccionado,
				'eqp_id': $scope.equipoSeleccionado,
				'jug_id': jugador_id,
				'plt_numero_camiseta': obtenerSiguienteNumeroCamiseta(),
			};

			Plantillas.save(
				plantilla,
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                refrescarJugadores();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
			);
		}

		//********Actualiza el numero de camiseta del jugador seleccionado***********
		$scope.actualizarJugadorEnPlantilla = function (plantilla_id, jugador_id, numero_camiseta){

			var plantilla = {
				'tor_id': $scope.torneoSeleccionado, 
				'eqp_id': $scope.equipoSeleccionado,
				'jug_id': jugador_id,
				'plt_numero_camiseta': numero_camiseta,
			};

			Plantillas.update(
				{plantilla: plantilla_id},
				plantilla,
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));	             
	                alert(response.data);
	                refrescarJugadores();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
			);
		}

		//********Eliminar un jugador de la plantilla del equipo y el torneo seleccionado***********
		$scope.eliminarJugadorEnPlantilla = function (plantilla_id){

			Plantillas.delete(
				{plantilla: plantilla_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));	             
	                alert(response.data);
	                refrescarJugadores();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
			);
		}


		function obtenerSiguienteNumeroCamiseta() {
			var numero = 0;

			for(var jugador in $scope.jugadores){
				if (!isNaN(jugador)){
					if ($scope.jugadores[jugador].pivot.plt_numero_camiseta > numero){
						numero = $scope.jugadores[jugador].pivot.plt_numero_camiseta;
					}
				}
			}

			return numero + 1;
		}

		function refrescarJugadores(){
			$scope.obtenerJugadores($scope.equipoSeleccionado);
		}
	}
]);