'use strict';

/* Controllers */

var plantillaControllers = angular.module('plantillaControllers', []);
var torneoControllers = angular.module('torneoControllers', []);
var tablasControllers = angular.module('tablasControllers', []);
var fechasControllers = angular.module('fechasControllers', []);


plantillaControllers.controller('PlantillasCtrl', ['$scope','EquiposParticipantes','JugadoresInscritos','Plantillas',

	function($scope, EquiposParticipantes, JugadoresInscritos, Plantillas) {
 
		$scope.equipos = [];
		$scope.jugadores = [];
		$scope.torneoSeleccionado = false;
		$scope.equipoSeleccionado = false;
		$scope.equipoNombre = "";
	 	

		//********Carga los jugadores del equipo y el torneo seleccionado***********
		function obtenerJugadores() {
			JugadoresInscritos.get(
	            {
            		torneo: $scope.torneoSeleccionado, 
            		equipo: $scope.equipoSeleccionado.eqp_id
            	},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.jugadores = response;
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

	 	//********Carga los equipos en base al id del Torneo seleccionado***********
		$scope.obtenerEquipos = function(torneo_id) {
			EquiposParticipantes.get(
	            {torneo: torneo_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                $scope.equipos = response;
	                $scope.torneoSeleccionado = torneo_id;
	                $scope.jugadores = [];
	                $scope.equipoSeleccionado = null;
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
	        );
		}


		$scope.seleccionarEquipo = function(index){
			$scope.equipoSeleccionado = $scope.equipos[index];
			obtenerJugadores();
		}

		//********Agrega un jugador a la plantilla del equipo y el torneo seleccionado***********
		$scope.ingresarJugadorEnPlantilla = function (jugador_id){

			var plantilla = {
				'tor_id': $scope.torneoSeleccionado,
				'eqp_id': $scope.equipoSeleccionado.eqp_id,
				'jug_id': jugador_id,
				'plt_numero_camiseta': obtenerSiguienteNumeroCamiseta(),
			};

			Plantillas.save(
				plantilla,
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));
	                alert(response.data);
	                obtenerJugadores();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
			);
		}

		//********Actualiza el numero de camiseta del jugador seleccionado***********
		$scope.actualizarJugadorEnPlantilla = function (index){

			var plantilla = {
				'tor_id': $scope.torneoSeleccionado, 
				'eqp_id': $scope.equipoSeleccionado.eqp_id,
				'jug_id': $scope.jugadores[index].jug_id,
				'plt_numero_camiseta': $scope.jugadores[index].pivot.plt_numero_camiseta,
			};

			Plantillas.update(
				{plantilla: $scope.jugadores[index].pivot.plt_id},
				plantilla,
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));	             
	                alert(response.data);
	                obtenerJugadores();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
	            }
			);
		}

		//********Eliminar un jugador de la plantilla del equipo y el torneo seleccionado***********
		$scope.eliminarJugadorEnPlantilla = function (index){

			Plantillas.delete(
				{plantilla: $scope.jugadores[index].pivot.plt_id},
	            function success(response){
	                console.log("Success:" + JSON.stringify(response));	             
	                alert(response.data);
	                obtenerJugadores();
	            },
	            function error(errorResponse){
	            	alert('Ocurrió un error.');
	                console.log("Error:" + JSON.stringify(errorResponse));
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
	                $scope.faseSeleccionada = -1;
	                $scope.obtenerTabla();
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

		$scope.obtenerTabla = function(){
			Tablas.get(
				{torneo:  $scope.torneoSeleccionado.tor_id, fase: $scope.faseSeleccionada},
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