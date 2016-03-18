'use strict';

/* Controllers */

var plantillaControllers = angular.module('plantillaControllers', []);
var torneoControllers = angular.module('torneoControllers', []);
var tablasControllers = angular.module('tablasControllers', []);
var fechasControllers = angular.module('fechasControllers', []);
var partidosControllers = angular.module('partidosControllers', []);


plantillaControllers.controller('PlantillasCtrl', [
	'$scope','EquiposParticipantes','Plantillas','Torneos','$timeout',

	function($scope, EquiposParticipantes, Plantillas, Torneos, $timeout) {
 
 		$scope.paso = 0;
		$scope.torneos = [];
		$scope.equipos = [];
		$scope.jugadores = [];
		$scope.torneoSeleccionado = false;
		$scope.equipoSeleccionado = false;
		$scope.botonAnteriorActivado = false;
		$scope.botonSiguienteActivado = false;
		$scope.alerts = [];

		function errorHandler(error, code){
			switch(code){
				case 404:
					createAlert('danger', 'Error: Operación no encontrada.');
					break;
				case 422:
					angular.forEach(error, function(value, key) {
				  		createAlert('danger', 'Error: ' + value);
					});
					error = JSON.stringify(error);
					break;
				case 500:
					createAlert('danger', 'Error: Operación no permitida.');
					break;
				default:
					alert('Error!');
					break;
			}
			console.log("ERROR:" + error);	
		}	 	

		function createAlert(type, message){
			$scope.alerts.push({ type: type, msg: message });
		}

		$scope.closeAlert = function(index) {
			if ($scope.alerts.length >= (index + 1))
				$scope.alerts.splice(index, 1);
		}

		/************************OBTENER INFORMACION Y CARGAR PASOS******************************/
		function obtenerTodosLosTorneos(){
			Torneos.query(
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                $scope.torneos = response;

	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function obtenerEquiposParticipantes(torneo_id) {
			EquiposParticipantes.get(
	            {torneo: torneo_id},
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                $scope.equipos = response;
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function obtenerJugadores(torneo_id, equipo_id) {
			Plantillas.query(
	            {torneo: torneo_id, equipo: equipo_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.jugadores = response;
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}


		/************************CaMBIAR PASO ACTUAL******************************/
		// $scope.prepararPaso = function(paso){
		function prepararPaso(paso){
			switch(paso){
				case 1:
					obtenerTodosLosTorneos();
					$scope.equipos = [];
					$scope.jugadores = [];
					$scope.torneoSeleccionado = false;
					$scope.equipoSeleccionado = false;
					$scope.botonAnteriorActivado = false;
					$scope.botonSiguienteActivado = false;
					break;
				case 2:
					obtenerEquiposParticipantes($scope.torneoSeleccionado.tor_id);
					$scope.jugadores = [];
					$scope.equipoSeleccionado = false;
					$scope.botonAnteriorActivado = true;
					$scope.botonSiguienteActivado = false;
					break;
				case 3:
					obtenerJugadores($scope.torneoSeleccionado.tor_id, $scope.equipoSeleccionado.eqp_id);
					$scope.botonAnteriorActivado = true;
					$scope.botonSiguienteActivado = false;
					break;
			}

			$scope.paso = paso;
			console.log('paso ' + $scope.paso);
		}		

		$scope.seleccionarTorneo = function(){
			prepararPaso(2);
		}

		$scope.seleccionarEquipo = function(equipo){
			$scope.equipoSeleccionado = equipo;
			prepararPaso(3);			
		}

		$scope.volverPaso = function(){
			prepararPaso($scope.paso - 1);
		}

		$scope.avanzarPaso = function(){
			prepararPaso($scope.paso + 1);
		}

		/************************MANEJO DE PLANTILLA******************************/
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

		$scope.ingresarJugadorEnPlantilla = function (jugador_id){
			var plantilla = {
				'tor_id': $scope.torneoSeleccionado.tor_id,
				'eqp_id': $scope.equipoSeleccionado.eqp_id,
				'jug_id': jugador_id,
				'plt_numero_camiseta': obtenerSiguienteNumeroCamiseta(),
			};

			Plantillas.save(
				plantilla,
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                createAlert('success','Jugador ingresado exitosamente en plantilla!');
	                prepararPaso(3);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
			);
		}

		$scope.actualizarJugadorEnPlantilla = function (index){

			var plantilla = {
				'tor_id': $scope.torneoSeleccionado.tor_id, 
				'eqp_id': $scope.equipoSeleccionado.eqp_id,
				'jug_id': $scope.jugadores[index].jug_id,
				'plt_numero_camiseta': $scope.jugadores[index].pivot.plt_numero_camiseta,
			};

			Plantillas.update(
				{plantilla: $scope.jugadores[index].pivot.plt_id},
				plantilla,
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));	             
	                prepararPaso(3);
	                createAlert('success','Jugador actualizado exitosamente en plantilla!');
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
			);
		}

		$scope.eliminarJugadorEnPlantilla = function (index){

			Plantillas.delete(
				{plantilla: $scope.jugadores[index].pivot.plt_id},
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));	     
	                prepararPaso(3);
	                createAlert('warning','Jugador eliminado exitosamente de plantilla!');
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
			);
		}			

		
	}
]);

torneoControllers.controller('TorneoCtrl', [
	'$scope','$modal','$timeout','EquiposParticipantes','Torneos','TiposFase','Fases','Fechas',
	
	function($scope, $modal, $timeout, EquiposParticipantes, Torneos, TiposFase, Fases, Fechas){
		
		var pasoActual = 1;
		var totalPasos = 5;
		$scope.torneoSeleccionado = null;
		$scope.equipos = [];
		$scope.numeroFechas = 12;
	 	$scope.fases = [];
	 	$scope.erroresFase = [];
	 	$scope.faseSeleccionada = null;
	 	$scope.faseSeleccionadaFila = null;
	 	$scope.tiposFase = [];
	 	$scope.tipoFaseSeleccionado = null;
	 	$scope.fechas = [];
	 	$scope.erroresFecha = [];
	 	$scope.fechaCalendario = {
 			abierto: false,
 			valor: null
	 	};



		function obtenerEquipos() {
			EquiposParticipantes.get(
	            {torneo: $scope.torneoSeleccionado.tor_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.equipos = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

		function obtenerEquipoIdDesdeVista(index){
			return angular.element("#tbl_equipos tbody tr").eq(index)
						.find("td:first input[name='eqp_id']").val();
		}

		function equiposIncompletos(){
			var respuesta = true;
			if ($scope.torneoSeleccionado) {
				if ($scope.equipos.length == $scope.torneoSeleccionado.tor_numero_equipos){
					// alert('Cuota de equipos para el torneo completa.');
					respuesta = false;
				}
			}
			return respuesta;
		}

		function obtenerFases(){
			Fases.query(
	            {torneo: $scope.torneoSeleccionado.tor_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.fases = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

		function obtenerFaseIdDesdeVista(index){
			return angular.element("#tbl_fases tbody tr").eq(index)
						.find("td:first input[name='fas_id']").val();
		}

		function obtenerTiposFase(){
			TiposFase.query(
	            {},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	        		$scope.tiposFase = response;
	            },
	            function error(errorResponse){
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

		function obtenerFechas(){
			Fechas.query(
	            {fase: $scope.faseSeleccionada.fas_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	        		$scope.fechas = agregarVariableCalendario(
	        			convetirAtributoStringADate(response, 'fec_fecha_referencia')
        			);
	            },
	            function error(errorResponse){
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

		function agregarVariableCalendario(data){
			angular.forEach(data, function(value, key) {
				value['calendarioAbierto'] = false;
				// value['fec_fecha_referencia'] = new Date(value['fec_fecha_referencia']+'T05:00:00.000Z');
			});
			return data;
		}

		function convetirAtributoStringADate(data, atributo){
			angular.forEach(data, function(value, key) {
				value[atributo] = new Date(value[atributo]+'T05:00:00.000Z');
			});
			return data;
		}


	 	//********Funciones inmersas en el scope***********

	 	$scope.colocarTorneo = function(torneo_id){
			Torneos.get(
	            {torneo: torneo_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.torneoSeleccionado = response;
	                $scope.siguientePaso();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

	 	$scope.inscribirEquipo = function(equipo_id){
			var equipo = {
				'tor_id': $scope.torneoSeleccionado.tor_id,
				'eqp_id': equipo_id,
			}

			EquiposParticipantes.save(
				{},
				equipo,
				function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                obtenerEquipos();
	            },
	            function error(errorResponse){
	            	console.log("Error:" + JSON.stringify(errorResponse));
	            	alert(errorResponse.data);
            	}
			);
		}

		$scope.eliminarEquipoInscrito = function(index){
			EquiposParticipantes.delete(
				{
					torneo: $scope.torneoSeleccionado.tor_id, 
					equipo: $scope.equipos[index].eqp_id
				},
				function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                obtenerEquipos();
	            },
	            function error(errorResponse){
	            	console.log("Error:" + JSON.stringify(errorResponse));
	            	alert(errorResponse.data);
            	}
			);
		}

		$scope.ingresarFase = function(){
			var fase = {
				fas_descripcion: angular.element('#txt_fase_descripcion').val(),
				tfa_id: $scope.tipoFaseSeleccionado, //angular.element('#cbo_tipo_fase').val(),
				tor_id: $scope.torneoSeleccionado.tor_id,
				num_fechas: $scope.numeroFechas,
			}

			Fases.save(
				{},
				fase,
				function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                angular.element('#txt_fase_descripcion').val("");
	                angular.element('#cbo_tipo_fase').val("");
	                obtenerFases();
	            },
	            function error(errorResponse){
	            	$scope.erroresFase = [];
	            	angular.forEach(errorResponse.data, function(value, key) {
				  		this.push(value[0]);
					}, $scope.erroresFase);
	                console.log("Error:" + JSON.stringify($scope.erroresFase));
	                $timeout(function() { 
				 		$scope.erroresFase = []; 
				 	}, 5000);
            	}
			);
		}

		$scope.seleccionarFase = function(index){
			$scope.faseSeleccionadaFila = index;
			$scope.faseSeleccionada = $scope.fases[index];
		}

		$scope.eliminarFase = function(index){
			Fases.delete(
				// {fase: obtenerFaseIdDesdeVista(index)},
				{fase: $scope.fases[index].fas_id},
				function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                $scope.faseSeleccionadaFila = null;
					$scope.faseSeleccionada = null;
	                obtenerFases();
	            },
	            function error(errorResponse){
	            	console.log("Error:" + JSON.stringify(errorResponse));
	            	alert("Ocurrió un error.");
            	}
			);
		}

		$scope.ingresarFecha = function(){
			var fecha = {
				fec_numero: 1,
				fec_fecha_referencia: $scope.fechaCalendario.valor.toISOString().substring(0,10),
				fas_id: $scope.faseSeleccionada.fas_id
			}

			Fechas.save(
				{},
				fecha,
				function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                $scope.fechaCalendario.valor = null;
	                obtenerFechas();
	            },
	            function error(errorResponse){
	            	$scope.erroresFecha = [];
	            	angular.forEach(errorResponse.data, function(value, key) {
				  		this.push(value[0]);
					}, $scope.erroresFecha);
	                console.log("Error:" + JSON.stringify($scope.erroresFecha));
	                $timeout(function() { 
				 		$scope.erroresFecha = []; 
				 	}, 5000);
            	}
			);
		}

		$scope.actualizarFecha = function(index){
			var fecha = {
				fec_numero: $scope.fechas[index].fec_numero,
				fec_fecha_referencia: $scope.fechas[index].fec_fecha_referencia.toISOString().substring(0,10),
				fas_id: $scope.fechas[index].fas_id
			}

			Fechas.update(
				{fecha: $scope.fechas[index].fec_id},
				fecha,
				function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                obtenerFechas();
	            },
	            function error(errorResponse){
	            	console.log("Error:" + JSON.stringify(errorResponse));
	            	alert(errorResponse.data);
            	}
			);
		}

		$scope.eliminarFecha = function(index){
			Fechas.delete(
				{fecha: $scope.fechas[index].fec_id},
				function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                obtenerFechas();
	            },
	            function error(errorResponse){
	            	console.log("Error:" + JSON.stringify(errorResponse));
	            	alert(errorResponse.data);
            	}
			);
		}




		$scope.obtenerAvanceWizard = function(){			
			return pasoActual.toString() + '/' + totalPasos.toString();
		}

		$scope.mostrarPaso = function(paso){
			return pasoActual == paso ? true : false;
		}

		$scope.siguientePaso = function(data){
			switch(pasoActual){
				case 1: obtenerEquipos();
						break;
				case 2: obtenerTiposFase();
						obtenerFases();						
						break;
				case 3: obtenerFechas();
						break;
			}

			pasoActual++;
			$scope.$digest();
		}

		$scope.anteriorPaso = function(){
			pasoActual--;
			switch(pasoActual){
				case 1: $scope.torneoSeleccionado = null;
						break;
				case 3: obtenerFases();						
						break;
			}
			// $scope.$digest();
		}

		$scope.dehabilitarAnterior = function(){
			var respuesta;

			switch(pasoActual){
				case 1: 
				case 2: 
						respuesta = true;
						break;
				default:respuesta = false;
						break;
			}

			return respuesta;
		}

		$scope.dehabilitarSiguiente = function(){
			var respuesta;

			switch(pasoActual){
				case 2: respuesta = equiposIncompletos();
						break;
				case 3: respuesta = $scope.faseSeleccionada == null ? true : false;
						break;
				case 4: respuesta = $scope.fechas.length == 0 ? true : false;
						break;
				default:respuesta = true;
						break;
			}

			return respuesta;
		}

		$scope.equiposCompletos = function(){
			return !equiposIncompletos();
		}



		$scope.showModal = function() {

	        $scope.opts = {
		        backdrop: true,
		        backdropClick: true,
		        dialogFade: false,
		        keyboard: true,
		        templateUrl : '/tipo_fase/nuevo',
		        controller : ModalCtrl,
		        resolve: {} // empty storage
	      	};


	      	var modalInstance = $modal.open($scope.opts);

	      	modalInstance.result.then(
	      		function(){
	          	},
	          	function(){
	            	console.log("Modal Closed");
	      		},
	      		function(){
	        		alert('whaaaat');
	          	}
      		);
	  	}

	  	var ModalCtrl = function($scope, $modalInstance, $modal, TiposFase) {

	  		$scope.alerts = [];

			$scope.ok = function () {

		      	var tipoFase = {
		      		tfa_nombre: angular.element('#tfa_nombre').val(),
		      		tfa_descripcion: angular.element('#tfa_descripcion').val(),
		      	}

		      	console.log("Success:" + JSON.stringify(tipoFase));

		      	TiposFase.save(
		            {},
		            tipoFase,
		            function success(response){
		                console.log("Success:" + JSON.stringify(response));
		                alert(response.data);
		        		$modalInstance.close();
		            },
		            function error(errorResponse){
		            	$scope.alerts = "";
		            	angular.forEach(errorResponse.data, function(value, key) {
					  		this.push(value[0]);
						}, $scope.alerts);
		                console.log("Error:" + JSON.stringify($scope.alerts));
		            }
		        );
	      	};

	      	$scope.cancel = function () {
		        $modalInstance.dismiss('cancel');
	      	};
		}

		$scope.abrirCalendarioFecha = function($event) {
		    $event.preventDefault();
		    $event.stopPropagation();

	    	$scope.fechaCalendario.abierto = true;
	  	};

	  	$scope.abrirCalendarioListaFechas = function($event, index) {
		    $event.preventDefault();
		    $event.stopPropagation();

	    	$scope.fechas[index].calendarioAbierto = true;
	  	};
	}
]);

tablasControllers.controller('TablasCtrl', [
	'$scope','$window','Torneos','Tablas','Fases',
	
	function($scope, $window, Torneos, Tablas, Fases){
		
		$scope.torneos = [];
		$scope.torneoSeleccionado = null;
	 	$scope.fases = [];
	 	$scope.faseSeleccionada = null;
	 	$scope.tabla = [];



	 	$scope.initList = function(){
			$scope.obtenerTorneos();	 		
	 	}

	 	$scope.initPreview = function(torneo_id){
	 		$scope.definirTorneo(torneo_id);
	 	}

	 	$scope.irTabla = function(torneo){
   			$window.location.href = '/visual/torneo/'+ torneo.tor_id +'/tablas';
	 	}

	 	$scope.obtenerTorneos = function(){
	 		Torneos.query(
	 			function success(response){
	                //console.log("Success:" + JSON.stringify(response));
	                $scope.torneos = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                // console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

	 	function obtenerFases(){
	 		Fases.query(
	 			{torneo: $scope.torneoSeleccionado.tor_id},
	 			function success(response){
	                //console.log("Success:" + JSON.stringify(response));
	                response.unshift({"fas_id":-1,"fas_descripcion":"Acumulada"});
	                $scope.fases = response;
	                // $scope.obtenerTabla($scope.fases[0]);
	                $scope.obtenerTabla($scope.fases[$scope.fases.length - 1]);
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

	 	$scope.definirTorneo = function(torneo_id){
			Torneos.get(
	            {torneo: torneo_id},
	            function success(response){
	                //console.log("Success:" + JSON.stringify(response));
	                $scope.torneoSeleccionado = response;
	                obtenerFases();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                // console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}

		$scope.obtenerTabla = function(fase){
			// alert(JSON.stringify(fase));
			// if (fase != null){
				$scope.faseSeleccionada = fase;//$scope.fases[index].fas_id;
			// }<div></div>
			// alert(JSON.stringify($scope.faseSeleccionada));
	        console.log("Success:" + JSON.stringify($scope.faseSeleccionada));
			Tablas.get(
				{torneo:  $scope.torneoSeleccionado.tor_id, fase: $scope.faseSeleccionada.fas_id},
				function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                $scope.tabla = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
			);
		}

		
	}
]);

fechasControllers.controller('FechasCtrl', [
	'$scope','$window','Torneos','Fases','Fechas','Partidos',
	
	function($scope, $window, Torneos, Fases, Fechas, Partidos){
		
		$scope.torneos = [];
		$scope.torneoSeleccionado = null;
	 	$scope.fases = [];
	 	$scope.faseSeleccionada = null;
	 	$scope.fechas = [];
	 	$scope.fechaSeleccionada = null;
	 	$scope.existeFechaAnterior = null;
	 	$scope.existeFechaSiguiente = null;
	 	$scope.partidos = [];



	 	$scope.initList = function(){
			$scope.obtenerTorneos();	 		
	 	}

	 	$scope.initPreview = function(fecha_id, fase_id){
	 		if (fase_id == -1)
	 			$scope.obtenerFecha(fecha_id);
	 		else
	 			$scope.obtenerFechaActual(fase_id);

 			// else
	 	}

	 	$scope.irFechaAnterior = function(anteriorFecha){
			// $scope.irFechaWidget($scope.fechaSeleccionada.fecha_anterior);	 		
			anteriorFecha($scope.fechaSeleccionada.fecha_anterior);	 		
	 	}

	 	$scope.irFechaSiguiente = function(siguienteFecha){
			// $scope.irFechaWidget($scope.fechaSeleccionada.fecha_siguiente);	 		
			siguienteFecha($scope.fechaSeleccionada.fecha_siguiente);	 		
	 	}

	 	$scope.irFechaTabla = function(fecha){
   			$window.location.href = '/visual/fechas/'+ fecha.fec_id +'/partidos';
	 	}

	 	$scope.irFechaWidget = function(fecha){
   			$window.location.href = '/visual/widget/fechas/'+ fecha.fec_id +'/partidos';
	 	}

	 	$scope.obtenerTorneos = function(){
	 		Torneos.query(
	 			function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.torneos = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

	 	$scope.obtenerFase = function(fase_id){
	 		Fases.get(
	 			{fase: fase_id},
	 			function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.faseSeleccionada = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

	 	$scope.obtenerFases = function(){
	 		Fases.query(
	 			{torneo: $scope.torneoSeleccionado.tor_id},
	 			function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.fases = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

	 	$scope.obtenerFecha = function (fecha_id){
	 		Fechas.get(
	 			{fecha: fecha_id},
	 			function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.fechaSeleccionada = response;
	                $scope.existeFechaAnterior = $scope.fechaSeleccionada.fecha_anterior != null ? true : false;
	                $scope.existeFechaSiguiente = $scope.fechaSeleccionada.fecha_siguiente != null ? true : false;
	                $scope.obtenerFase($scope.fechaSeleccionada.fas_id);
	                $scope.obtenerPartidos();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

	 	$scope.obtenerFechaActual = function (fase_id){
	 		Fechas.actual(
	 			{fase: fase_id},
	 			function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.fechaSeleccionada = response;
	                $scope.existeFechaAnterior = $scope.fechaSeleccionada.fecha_anterior != null ? true : false;
	                $scope.existeFechaSiguiente = $scope.fechaSeleccionada.fecha_siguiente != null ? true : false;
	                $scope.obtenerFase($scope.fechaSeleccionada.fas_id);
	                $scope.obtenerPartidos();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

	 	$scope.obtenerFechas = function (){
	 		Fechas.query(
	 			{fase: $scope.faseSeleccionada.fas_id},
	 			function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.fechas = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
 			);
	 	}

		$scope.obtenerPartidos = function(){
			Partidos.query(
				{fecha:  $scope.fechaSeleccionada.fec_id},
				function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                angular.forEach(response, function(value, key) {
		                if (value.par_goles_local != null)
		                	value['separador'] = 'x';
		                else
		                	value['separador'] = 'VS';
					});
	                
	                console.log("Success:" + JSON.stringify(response));
	                $scope.partidos = response;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                // console.log("Error:" + JSON.stringify(errorResponse));
	            }
			);
		}

		
	}
]);

partidosControllers.controller('PartidosCtrl', [
	'$scope','$uibModal','EquiposParticipantes','JugadoresInscritos','Torneos', 'Fases', 'Fechas', 
	'Partidos', 'Plantillas', 'Titulares', 'Sustituciones', 'Goles', 'Amonestaciones',

	function($scope, $uibModal, EquiposParticipantes, JugadoresInscritos, Torneos, Fases, Fechas, 
		Partidos, Plantillas, Titulares, Sustituciones, Goles, Amonestaciones) {
 
 		$scope.templates = {gol: 'goles.tpl', sustitucion:'sustituciones.tpl', amonestacion: 'amonestaciones.tpl'};
 		$scope.controladores = {gol: 'ModalInstanceCtrl', sustitucion:'SustitucionesCtrl', amonestacion: 'AmonestacionesCtrl'};
 		$scope.paso = 0;
		$scope.torneos = [];
		$scope.torneoSeleccionado = false;
		$scope.fases = [];
		$scope.faseSeleccionada = false;
		$scope.fechas = [];
		$scope.fechaSeleccionada = false;
		$scope.partidos = [];
		$scope.partidoSeleccionado = false;
		$scope.plantillas = {local: [], visitante: []};
		$scope.titulares = {local: [], visitante: []};
		$scope.sustituciones = {local: [], visitante: []};
		$scope.en_cancha = {local: [], visitante: []};
		$scope.goles = {local: [], visitante: []};
		$scope.amonestaciones = {local: [], visitante: []};

		$scope.jugadores = [];

		$scope.modalShown = false;
		$scope.botonAnteriorActivado = false;
		$scope.botonSiguienteActivado = false;
		$scope.alerts = [];

		
		$scope.fake = function() {
			$scope.torneoSeleccionado = { tor_jugadores_por_equipo: 11};
			$scope.partidoSeleccionado = {
				par_id:33, 
				equipo_local:{eqp_id: 3, eqp_nombre: "Barcelona"}, 
				equipo_visitante:{eqp_id: 8, eqp_nombre: "Independiente"}
			};
			// obtenerEstadoJugadores($scope.partidoSeleccionado.par_id);

			// obtenerPlantillasTitulares(1, 18, 12, $scope.plantillas.local, $scope.titulares.local);
			// obtenerPlantillasTitulares(1, 18, 7, $scope.plantillas.visitante, $scope.titulares.visitante);
			// setTimeout(2999);
			// obtenerGoles(18);
			// $scope.paso = 6;
			prepararPaso(6);
		}

		function errorHandler(error, code) {
			switch(code){
				case 404:
					createAlert('danger', 'Error: Operación no encontrada.');
					break;
				case 422:
					angular.forEach(error, function(value, key) {
				  		createAlert('danger', 'Error: ' + value);
					});
					error = JSON.stringify(error);
					break;
				case 500:
					createAlert('danger', 'Error: Operación no permitida.');
					break;
				default:
					alert('Error!');
					break;
			}
			console.log("ERROR:" + error);	
		}	 	

		function createAlert(type, message) {
			$scope.alerts.push({ type: type, msg: message });
		}

		$scope.closeAlert = function(index) {
			if ($scope.alerts.length >= (index + 1))
				$scope.alerts.splice(index, 1);
		}

		/************************ TORNEOS ******************************/
		function obtenerTodosLosTorneos() {
			Torneos.query(
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                /***********************************************************/
	                // TODO  ->  Agregar numero de jugadores por equipo
	                response.map( function(torneo){ torneo.tor_jugadores_por_equipo = 11; });
	                /***********************************************************/
	                $scope.torneos = response;

	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		$scope.seleccionarTorneo = function() {
			prepararPaso(2);
		}

		/************************ FASES ******************************/
		$scope.seleccionarFase = function(fase) {
			$scope.faseSeleccionada = fase;
			prepararPaso(3);
		}

		function obtenerFases(torneo_id) {
			Fases.query(
				{torneo: torneo_id},
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                $scope.fases = response;

	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		/************************ FECHAS ******************************/
		function obtenerFechas(fase_id) {
			Fechas.query(
				{fase: fase_id},
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                $scope.fechas = response;

	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		$scope.seleccionarFecha = function(fecha) {
			$scope.fechaSeleccionada = fecha;
			prepararPaso(4);
		}

		/************************ PARTIDOS ******************************/
		function obtenerPartidos(fecha_id) {
			Partidos.query(
				{fecha: fecha_id},
	            function success(response){
	                // console.log("Success:" + JSON.stringify(response));
	                $scope.partidos = response;
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function obtenerEstadoPartido(partido_id) {
			Partidos.status(
				{partido: partido_id},
	            function success(response){
	                $scope.jugadores = response;

	                llenarPlantillas(response);
		            llenarTitulares(response);
		            llenarSustituciones(response);
		            llenarJugadoresEnCancha(response);
		            seleccionarTitulares();
		            llenarGoles(response.local.goles, response.visitante.goles);
		            llenarAmonestaciones(response.local.amonestaciones, response.visitante.amonestaciones);

			        if (response.iniciado) {
		            	bloquearJugadores($scope.plantillas.local, $scope.plantillas.local);
		            	bloquearJugadores($scope.plantillas.visitante, $scope.plantillas.visitante);
		            }

		            evaluarEquiposCompletos($scope.plantillas.local, $scope.plantillas.visitante);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );	
		}

		$scope.seleccionarPartido = function(partido) {
			$scope.partidoSeleccionado = partido;
			prepararPaso(5);
		}

		/************************ PLANTILLAS ******************************/

		function obtenerEstadoJugadores(partido_id) {
			Titulares.state(
				{partido: partido_id},
	            function success(response){
	                $scope.jugadores = response;

	                llenarPlantillas(response);
		            llenarTitulares(response);
		            llenarSustituciones(response);
		            llenarJugadoresEnCancha(response);
		            seleccionarTitulares();

			        if (verificarPartidoIniciado()) {
		            	bloquearJugadores($scope.plantillas.local, $scope.plantillas.local);
		            	bloquearJugadores($scope.plantillas.visitante, $scope.plantillas.visitante);
		            }

		            evaluarEquiposCompletos($scope.plantillas.local, $scope.plantillas.visitante);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function llenarPlantillas(jugadores) {
			$scope.plantillas.local = jugadores.local.plantilla;
			$scope.plantillas.visitante = jugadores.visitante.plantilla;			
		}

		function llenarTitulares(jugadores) {
			$scope.titulares.local = jugadores.local.titulares;
			$scope.titulares.visitante = jugadores.visitante.titulares;
		}

		function llenarSustituciones(jugadores) {
			$scope.sustituciones.local = jugadores.local.sustituciones;
			$scope.sustituciones.visitante = jugadores.visitante.sustituciones;
		}

		function llenarJugadoresEnCancha(jugadores) {
			$scope.en_cancha.local = jugadores.local.en_cancha;
			$scope.en_cancha.visitante = jugadores.visitante.en_cancha;
		}

		function seleccionarTitulares() {
			seleccionarTitularesEnPlantilla($scope.plantillas.local, $scope.titulares.local);
			seleccionarTitularesEnPlantilla($scope.plantillas.visitante, $scope.titulares.visitante);
		}

		function seleccionarTitularesEnPlantilla(plantilla, titulares) {
			plantilla
                .filter(function (j){ return titulares.filter(function (t){ return t.jug_id ==  j.jug_id; }).length; })
                .map( function (jugador) { jugador.seleccionado = true; });
		}

		function verificarPartidoIniciado() {
			var iniciado = false;
			if ($scope.sustituciones.local.length + $scope.sustituciones.visitante.length >0) {
				iniciado = true;
			}
			return iniciado;
		}

		function ingresarJugadoresTitulares(jugadores, partido_id, equipo_id) {
			Titulares.bulk(
				{partido: partido_id, equipo: equipo_id},
				jugadores,
	            function success(response){
	                
	                evaluarEquiposCompletos($scope.plantillas.local, $scope.plantillas.visitante);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		$scope.ingresarTitularesPorPlantilla = function(plantilla, equipo) {
			var titulares = obtenerTitularesPlantilla(plantilla);
			var equipoId = equipo.eqp_id;
			var equipoCompleto = evaluarTitularesCompletos(plantilla);
			
			if ( equipoCompleto || titulares.length % 3 === 0 ) {
				ingresarJugadoresTitulares(titulares, $scope.partidoSeleccionado.par_id, equipoId);
			}
		}

		function evaluarEquiposCompletos(platillaLocal, plantillaVisitante) {
			var equiposLocalCompleto = evaluarEquipoCompleto(platillaLocal);
			var equiposVisitanteCompleto = evaluarEquipoCompleto(plantillaVisitante);

			$scope.botonSiguienteActivado = equiposLocalCompleto && equiposVisitanteCompleto ? true : false;
		}

		function evaluarEquipoCompleto(plantilla) {
			var equipoCompleto = evaluarTitularesCompletos(plantilla);
			
			if (equipoCompleto){
				bloquearJugadores(plantilla, obtenerNoTitularesPlantilla(plantilla) );
			}
			else {
				desbloquearJugadores(plantilla, plantilla);	
			}
			
			return equipoCompleto;
		}

		function evaluarTitularesCompletos(plantilla) {
			var maxJugadoresPorEquipo = $scope.torneoSeleccionado.tor_jugadores_por_equipo;
			var titulares = obtenerTitularesPlantilla(plantilla);

			return titulares.length == maxJugadoresPorEquipo;
		}

		function obtenerTitularesPlantilla(plantilla) {
			return plantilla.filter(function (jugador){ return jugador.seleccionado });
		}

		function obtenerNoTitularesPlantilla(plantilla) {
			return plantilla.filter(function (jugador){ return !jugador.seleccionado  });
		}		

		function desbloquearJugadores(plantilla, jugadores) {
			definirBloqueoJugadores(plantilla, jugadores, false);
		}

		function bloquearJugadores(plantilla, jugadores) {
			definirBloqueoJugadores(plantilla, jugadores, true);
		}

		function definirBloqueoJugadores(plantilla, jugadores, bloquear) {
			plantilla
                .filter(function (j){ return jugadores.filter(function (t){ return t.jug_id ==  j.jug_id; }).length; })
                .map( function (jugador) { jugador.bloqueado = bloquear; });	
		}
		/************************ GOLES ******************************/
		function obtenerGoles(partido_id) {
			Goles.query(
				{partido: partido_id},
	            function success(response){
	            	llenarGoles(
	            		response.filter(function (gol){ return gol.eqp_id ==  $scope.partidoSeleccionado.equipo_local.eqp_id; }),
	            		response.filter(function (gol){ return gol.eqp_id ==  $scope.partidoSeleccionado.equipo_visitante.eqp_id; })
	            	);
	                // $scope.goles.local = response.filter(function (gol){ return gol.eqp_id ==  $scope.partidoSeleccionado.equipo_local.eqp_id; });
	                // $scope.goles.visitante = response.filter(function (gol){ return gol.eqp_id ==  $scope.partidoSeleccionado.equipo_visitante.eqp_id; });
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function llenarGoles(golesLocal, golesVisitante) {
			$scope.goles.local = golesLocal;
            $scope.goles.visitante = golesVisitante;
		}

		$scope.golIngresar = function() {
			abrirModal($scope.templates.gol, $scope.controladores.gol, null);
		}

		function golIngresado() {
			createAlert('success', "Gol ingresado");
			obtenerGoles($scope.partidoSeleccionado.par_id);
		}

		$scope.golEditar = function(gol) {
			abrirModal($scope.templates.gol, gol);
		}

		$scope.golEliminar = function(gol) {
			Goles.delete(
				{gol: gol.gol_id},
	            function success(response){
	                $scope.goles.local = $scope.goles.local.filter(function (golActual){ return golActual.gol_id !=  gol.gol_id; })
	                $scope.goles.visitante = $scope.goles.visitante.filter(function (golActual){ return golActual.gol_id !=  gol.gol_id; })
	                createAlert('success', "Gol eliminado");
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}
		
		/********************** SUSTITUCIONES ************************/
		$scope.sustitucionIngresar = function () {
			abrirModal($scope.templates.sustitucion, $scope.controladores.sustitucion, null);
		}

		$scope.sustitucionEditar = function (sustitucion) {
			abrirModal($scope.templates.sustitucion, $scope.controladores.sustitucion, sustitucion);
		}

		$scope.sustitucionEliminar = function (sustitucion) {
			Sustituciones.delete(
				{sustitucion: sustitucion.pju_id},
	            function success(response){
	                createAlert('success', "Gol eliminado");
	                obtenerEstadoPartido($scope.partidoSeleccionado.par_id);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function sustitucionIngresada() {
			createAlert('success', "Sustitucion ingresada");
			obtenerEstadoJugadores($scope.partidoSeleccionado.par_id);
		}

		/********************** AMONESTACIONES ************************/
		$scope.amonestacionIngresar = function () {
			abrirModal($scope.templates.amonestacion, $scope.controladores.amonestacion, null);
		}

		function llenarAmonestaciones(amonestacionesLocal, amonestacionesVisitante) {
			$scope.amonestaciones.local = amonestacionesLocal;
            $scope.amonestaciones.visitante = amonestacionesVisitante;
		}

		$scope.amonestacionEditar = function (amonestacion) {
			abrirModal($scope.templates.amonestacion, $scope.controladores.amonestacion, amonestacion);
		}

		function amonestacionIngresada() {
			createAlert('success', "Amonestacion ingresada");
			obtenerEstadoPartido($scope.partidoSeleccionado.par_id);
		}

		$scope.amonestacionEliminar = function (amonestacion) {
			Amonestaciones.delete(
				{amonestacion: amonestacion.amn_id},
	            function success(response){
	                createAlert('success', "Amonestacion eliminada");
	                obtenerEstadoPartido($scope.partidoSeleccionado.par_id);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		/**********************MANEJO DE CONTROLES DEL FORMULARIO************************/
		function prepararPaso(paso) {
			if (paso <= 1){
				$scope.torneos = [];
				$scope.torneoSeleccionado = false;
			}
			if (paso <= 2){
				$scope.fases = [];
				$scope.faseSeleccionada = false;
			}
			if (paso <= 3){
				$scope.fechas = [];
				$scope.fechaSeleccionada = false;
			}
			if (paso <= 4){
				$scope.partidos = [];
				$scope.partidoSeleccionado = false;
			}
			if (paso <= 5){
				$scope.plantillas = {local: [], visitante: []};
				$scope.titulares = {local: [], visitante: []};
			}
			if (paso <= 6){
				$scope.sustituciones = {local: [], visitante: []};
				$scope.en_cancha = {local: [], visitante: []};
				$scope.goles = {local: [], visitante: []};
				$scope.amonestaciones = {local: [], visitante: []};
			}

			$scope.botonSiguienteActivado = false;
			$scope.botonAnteriorActivado = paso > 1;

			switch(paso){
				case 1:
					obtenerTodosLosTorneos();
					break;
				case 2:
					obtenerFases($scope.torneoSeleccionado.tor_id);
					break;
				case 3:
					obtenerFechas($scope.faseSeleccionada.fas_id);
					break;
				case 4:
					obtenerPartidos($scope.fechaSeleccionada.fec_id);
					break;
				case 5:
					obtenerEstadoPartido($scope.partidoSeleccionado.par_id);
					// obtenerEstadoJugadores($scope.partidoSeleccionado.par_id);
					break;
				case 6:
					obtenerEstadoPartido($scope.partidoSeleccionado.par_id);
					// obtenerEstadoJugadores($scope.partidoSeleccionado.par_id);
					// obtenerGoles($scope.partidoSeleccionado.par_id);
					break;
			}

			$scope.paso = paso;
			console.log('paso ' + $scope.paso);
		}		
		
		function abrirModal(template, controlador, instancia) {
			var equipos = [$scope.partidoSeleccionado.equipo_local, $scope.partidoSeleccionado.equipo_visitante];
			
		    var modalInstance = $uibModal.open({
      			animation: true,
      			templateUrl: template,
      			controller: controlador,
      			size: 'lg',
      			resolve: {
	        		equipos: function () { return equipos; },
	        		partido: function () { return $scope.partidoSeleccionado; },
	        		jugadores: function () { return $scope.jugadores; },

	        		Goles: function () {return Goles;},
	        		Sustituciones: function () {return Sustituciones; },
	        		Amonestaciones: function () {return Amonestaciones; },

	        		gol: function () {return instancia;},
	        		sustitucion: function () {return instancia;},
	        		amonestacion: function () {return instancia;},
		      	}
		    });

		    modalInstance.result.then(function (type, result) {
		    	console.log(JSON.stringify(result));
		    	console.log(type);
		    	if (type == 'gol') {
		    		golIngresado(result);
		    	}
		    	if (type == 'sustitucion') {
		    		sustitucionIngresada();
		    	}
		    	if (type == 'amonestacion') {
		    		amonestacionIngresada();
		    	}
	      		
	      		console.log('Successful - '+ template +': ' + JSON.stringify(result));
		    }, function () {
		      	console.log('Error '+ template +': ' + new Date());
		    });
	  	}

		$scope.volverPaso = function() {
			prepararPaso($scope.paso - 1);
		}

		$scope.avanzarPaso = function() {
			prepararPaso($scope.paso + 1);
		}
	}
]);

partidosControllers.controller('ModalInstanceCtrl',
	function ($scope, $uibModalInstance, partido, equipos, jugadores, gol, Goles) {
		$scope.alerts = [];
		$scope.equipos = equipos;
		$scope.partido = partido;
		$scope.jugadores = jugadores.local.en_cancha.concat(jugadores.visitante.en_cancha);
		$scope.jugadas = ['jugada','esquina','contra','libre','penal','otro'];
		$scope.ejecuciones = ['disparo','cabeza','muslo','pecho','chilena','tijera','rebote','otro'];
		$scope.nuevoGol = definirValoresInicialesNuevoGol(gol);

		function errorHandler(error, code){
			switch(code){
				case 404:
					createAlert('danger', 'Error: Operación no encontrada.');
					break;
				case 422:
					angular.forEach(error, function(value, key) {
				  		createAlert('danger', 'Error: ' + value);
					});
					error = JSON.stringify(error);
					break;
				case 500:
					createAlert('danger', 'Error: Operación no permitida.');
					break;
				default:
					alert('Error!');
					break;
			}
			console.log("ERROR:" + error);	
		}

		function createAlert(type, message){
			$scope.alerts.push({ type: type, msg: message });
		}

		$scope.closeAlert = function(index) {
			if ($scope.alerts.length >= (index + 1))
				$scope.alerts.splice(index, 1);
		}

		function nuevoGolDefaults(){
			return {
				minuto: 0,
				equipo: $scope.equipos[0],
				autor: null,
				asistente: null,
				jugada: null,
				ejecucion: null
			};
		}

		function prepararGol(gol){
			return {
				gol_minuto: gol.minuto,
				gol_jugada: gol.jugada,
				gol_ejecucion: gol.ejecucion,
				gol_autor: gol.autor ? gol.autor.jug_id : null,
				gol_asistencia: gol.asistente ? gol.asistente.jug_id : null,
				eqp_id: gol.equipo.eqp_id,
				par_id: $scope.partido.par_id,
			};
		}

		function definirValoresInicialesNuevoGol(gol) {
			if(gol) {
				var equipo = $scope.equipos.filter(function (equipo){ return equipo.eqp_id == gol.eqp_id; });
				var autor = $scope.jugadores.filter(function (jugador){ return jugador.jug_id == gol.gol_autor; });
				var asistente = $scope.jugadores.filter(function (jugador){ return jugador.jug_id == gol.gol_asistencia; });

				return {
					id: gol.gol_id,
					minuto: gol.gol_minuto,
					equipo: $scope.equipos[$scope.equipos.indexOf(equipo[0])],
					autor: $scope.jugadores[$scope.jugadores.indexOf(autor[0])],
					asistente: $scope.jugadores[$scope.jugadores.indexOf(asistente[0])],
					jugada: gol.gol_jugada,
					ejecucion: gol.gol_ejecucion
				};
			}
			else {
				return nuevoGolDefaults();
			}
		}

		function ingresarNuevoGol(nuevoGol) {
			Goles.save(
				prepararGol(nuevoGol),
	            function success(response){
	                console.log(JSON.stringify(response));
	                $uibModalInstance.close('gol',response);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function editarGol(gol_id, nuevoGol) {
			Goles.update(
				{gol: gol_id},
				prepararGol(nuevoGol),
	            function success(response){
	                console.log(JSON.stringify(response));
	                $uibModalInstance.close('gol',response);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

	  	$scope.ok = function (nuevoGol) {
	    	if (nuevoGol.id) {
	    		editarGol(nuevoGol.id, nuevoGol);
	    	}
	    	else {
	    		ingresarNuevoGol(nuevoGol);
	    	}
	  	};

	  	$scope.cancel = function () {
	    	$uibModalInstance.dismiss('cancel');
	  	};
	}
);

partidosControllers.controller('SustitucionesCtrl',
	function ($scope, $uibModalInstance, partido, equipos, jugadores, sustitucion, Sustituciones) {
		$scope.alerts = [];
		$scope.equipos = equipos;
		$scope.partido = partido;
		$scope.jugadores = jugadores;
		$scope.en_cancha = [];
		$scope.disponibles = [];		
		$scope.nuevaSustitucion = definirValoresInicialesNuevaSustitucion(sustitucion);

		function errorHandler(error, code){
			switch(code){
				case 404:
					createAlert('danger', 'Error: Operación no encontrada.');
					break;
				case 422:
					angular.forEach(error, function(value, key) {
				  		createAlert('danger', 'Error: ' + value);
					});
					error = JSON.stringify(error);
					break;
				case 500:
					createAlert('danger', 'Error: Operación no permitida.');
					break;
				default:
					alert('Error!');
					break;
			}
			console.log("ERROR:" + error);	
		}

		function createAlert(type, message){
			$scope.alerts.push({ type: type, msg: message });
		}

		$scope.closeAlert = function(index) {
			if ($scope.alerts.length >= (index + 1))
				$scope.alerts.splice(index, 1);
		}

		$scope.seleccionarEquipo = function(index) {
			seleccionarEquipo(index);
		}

		function seleccionarEquipo(index) {
			var local = index ? false : true;

			$scope.en_cancha = obtenerJugadoresEnCancha(local);
			$scope.disponibles = obtenerJugadoresDisponibles(local);			
		}

		function nuevaSustitucionDefaults(){
			return {
				minuto: 1,
				equipo: null,
				sale: null,
				ingresa: null,
			};
		}

		function obtenerJugadoresEnCancha(local) {
			return local ? $scope.jugadores.local.en_cancha : $scope.jugadores.visitante.en_cancha;
		}

		function obtenerJugadoresDisponibles(local) {
			return local ? $scope.jugadores.local.disponibles : $scope.jugadores.visitante.disponibles;
		}

		function prepararSustitucion(sustitucion){
			return {
				par_id: $scope.partido.par_id,
				jug_id: sustitucion.ingresa.jug_id,
				eqp_id: sustitucion.equipo.eqp_id,
				pju_minuto_ingreso: sustitucion.minuto,
				pju_reemplazo_de: sustitucion.sale.jug_id,
				// pju_numero_camiseta: 0,
				// pju_juvenil: false
			};
		}

		function definirValoresInicialesNuevaSustitucion(sustitucion) {
			if(sustitucion) {
				var index = -1;
				var equipo = $scope.equipos.filter(function (equipo){ 
					index++;
					return equipo.eqp_id == sustitucion.eqp_id; 
				});
				seleccionarEquipo(index);
				// var autor = $scope.jugadores.filter(function (jugador){ return jugador.jug_id == gol.gol_autor; });
				// var asistente = $scope.jugadores.filter(function (jugador){ return jugador.jug_id == gol.gol_asistencia; });

				return {
					id: gol.gol_id,
					minuto: gol.gol_minuto,
					// equipo: $scope.equipos[$scope.equipos.indexOf(equipo[0])],
					// autor: $scope.jugadores[$scope.jugadores.indexOf(autor[0])],
					// asistente: $scope.jugadores[$scope.jugadores.indexOf(asistente[0])],
					jugada: gol.gol_jugada,
					ejecucion: gol.gol_ejecucion
				};
			}
			else {
				return nuevaSustitucionDefaults();
			}
		}

		function ingresarNuevaSustitucion(sustitucion) {
			Sustituciones.save(
				prepararSustitucion(sustitucion),
	            function success(response){
	                console.log(JSON.stringify(response));
	                $uibModalInstance.close('sustitucion',response);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function editarSustitucion(sustitucion_id, sustitucion) {
			Sustituciones.update(
				{sustitucion: sustitucion_id},
				prepararSustitucion(sustitucion),
	            function success(response){
	                console.log(JSON.stringify(response));
	                $uibModalInstance.close('sustitucion',response);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

	  	$scope.ok = function (nuevaSustitucion) {
	    	if (nuevaSustitucion.id) {
	    		// editarGol(nuevaSustitucion.id, nuevaSustitucion);
	    	}
	    	else {
	    		ingresarNuevaSustitucion(nuevaSustitucion);
	    	}
	  	};

	  	$scope.cancel = function () {
	    	$uibModalInstance.dismiss('cancel');
	  	};
	}
);

partidosControllers.controller('AmonestacionesCtrl',
	function ($scope, $uibModalInstance, partido, equipos, jugadores, amonestacion, Amonestaciones) {
		$scope.alerts = [];
		$scope.edicion = amonestacion ? true :false;
		$scope.equipos = equipos;
		$scope.partido = partido;
		$scope.jugadores = jugadores;
		$scope.tipos = ['amarilla','roja'];
		$scope.en_cancha = [];
		$scope.nuevaAmonestacion = definirValoresInicialesNuevaAmonestacion(amonestacion);

		function errorHandler(error, code){
			switch(code){
				case 404:
					createAlert('danger', 'Error: Operación no encontrada.');
					break;
				case 422:
					angular.forEach(error, function(value, key) {
				  		createAlert('danger', 'Error: ' + value);
					});
					error = JSON.stringify(error);
					break;
				case 500:
					createAlert('danger', 'Error: Operación no permitida.');
					break;
				default:
					alert('Error!');
					break;
			}
			console.log("ERROR:" + error);	
		}

		function createAlert(type, message){
			$scope.alerts.push({ type: type, msg: message });
		}

		$scope.closeAlert = function(index) {
			if ($scope.alerts.length >= (index + 1))
				$scope.alerts.splice(index, 1);
		}

		$scope.seleccionarEquipo = function(index) {
			seleccionarEquipo(index);
		}

		function seleccionarEquipo(index) {
			var local = index ? false : true;
			$scope.en_cancha = $scope.edicion ? obtenerJugadoresEquipo(local) : obtenerJugadoresEnCancha(local);
		}

		function nuevaAmonestacionDefaults(){
			return {
				minuto: 1,
				equipo: null,
				jugador: null,
				tipo: null,
			};
		}

		function obtenerJugadoresEnCancha(local) {
			return local ? $scope.jugadores.local.en_cancha : $scope.jugadores.visitante.en_cancha;
		}

		function obtenerJugadoresEquipo(local) {
			return local ? $scope.jugadores.local.plantilla : $scope.jugadores.visitante.plantilla;
		}

		function prepararAmonestacion(amonestacion){
			return {
				par_id: $scope.partido.par_id,
				jug_id: amonestacion.jugador.jug_id,
				eqp_id: amonestacion.equipo.eqp_id,
				amn_minuto: amonestacion.minuto,
				amn_tipo: amonestacion.tipo,
			};
		}

		function definirValoresInicialesNuevaAmonestacion(amonestacion) {
			if($scope.edicion) {
				var equipo = $scope.equipos.filter(function (e){ return e.eqp_id == amonestacion.eqp_id; })[0];
				var index = $scope.equipos.indexOf(equipo);
				seleccionarEquipo(index);
				var jugador = $scope.en_cancha.filter(function (j){ return j.jug_id == amonestacion.jug_id; })[0];

				var amn = {
					id: amonestacion.amn_id,
					minuto: amonestacion.amn_minuto,
					jugador: jugador,
					equipo: equipo,
					tipo: amonestacion.amn_tipo
				};

				// console.log(JSON.stringify(amn));

				return amn;
			}
			else {
				return nuevaAmonestacionDefaults();
			}
		}

		function ingresarNuevaAmonestacion(amonestacion) {
			Amonestaciones.save(
				prepararAmonestacion(amonestacion),
	            function success(response){
	                console.log(JSON.stringify(response));
	                $uibModalInstance.close('amonestacion',response);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

		function editarAmonestacion(amonestacion_id, amonestacion) {
	  		Amonestaciones.update(
	  			{amonestacion: amonestacion_id},
				prepararAmonestacion(amonestacion),
	            function success(response){
	                console.log(JSON.stringify(response));
	                $uibModalInstance.close('amonestacion',response);
	            },
	            function error(error){
	            	errorHandler(error.data, error.status);
	            }
	        );
		}

	  	$scope.ok = function (nuevaAmonestacion) {
	    	if (nuevaAmonestacion.id) {
	    		editarAmonestacion(nuevaAmonestacion.id, nuevaAmonestacion);
	    	}
	    	else {
	    		ingresarNuevaAmonestacion(nuevaAmonestacion);
	    	}
	  	};

	  	$scope.cancel = function () {
	    	$uibModalInstance.dismiss('cancel');
	  	};
	}
);
