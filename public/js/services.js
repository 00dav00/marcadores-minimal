'use strict';
/*	Services	*/
var	torneoServices = angular.module('torneoServices', ['ngResource']);

torneoServices.factory('Torneos', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/api/torneos/:torneo", 
				{torneo: '@torneo_id'},	
				{
					query:{
						url: '/api/torneos/',
						method:	'GET',	cache:	false,	isArray:	true
					},
					get:	{method:	'GET',	cache:	false,	isArray:	false},
					// save:	{method:	'POST',	cache:	false,	isArray:	false},
					// update:	{method:	'PUT',	cache:	false,	isArray:	false},
					// delete:	{method:	'DELETE',	cache:	false,	isArray:	false}
				}
			);
		}
	]
);

torneoServices.factory('TiposFase', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/api/tipo_fase/:tipo_fase_id", 
				{torneo: '@tipo_fase_id'},	
				{
					// get:	{method:	'GET',	cache:	false,	isArray:	false},
					query:	{method:	'GET',	cache:	false,	isArray:	true},
					save:	{method:	'POST',	cache:	false,	isArray:	false},
					// update:	{method:	'PUT',	cache:	false,	isArray:	false},
					// delete:	{method:	'DELETE',	cache:	false,	isArray:	false}
				}
			);
		}
	]
);

torneoServices.factory('Fases', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				'/api/fases/:fase',
				{fase: '@fase_id'},
				{
					get:	{method:	'GET',	cache:	false,	isArray:	false},
					query:	{
						url: '/api/torneos/:torneo/fases', 
						params: {torneo: '@torneo_id'},	
						method:	'GET',	cache:	false,	isArray:	true
					},
					save:	{method:	'POST',	cache:	false,	isArray:	false},
					// update:	{method:	'PUT',	cache:	false,	isArray:	false},
					delete:	{method:	'DELETE',	cache:	false,	isArray:	false}
				}
			);
		}
	]
);

torneoServices.factory('Fechas', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				'/api/fechas/:fecha',
				{fecha: '@fecha_id'},
				{
					get:	{method:	'GET',	cache:	false,	isArray:	false},
					actual:	{
						url: '/api/fases/:fase/fecha_actual', 
						params: {fase: '@fase_id'},	
						method:	'GET',	cache:	false,	isArray:	false
					},
					query:	{
						url: '/api/fases/:fase/fechas', 
						params: {fase: '@fase_id'},	
						method:	'GET',	cache:	false,	isArray:	true
					},
					save:	{method:	'POST',	cache:	false,	isArray:	false},
					update:	{method:	'PUT',	cache:	false,	isArray:	false},
					delete:	{method:	'DELETE',	cache:	false,	isArray:	false}
				}
			);
		}
	]
);

torneoServices.factory('Partidos', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				'/api/partidos/:partido',
				{partido: '@partido_id'},
				{
					// get:	{method:	'GET',	cache:	false,	isArray:	false},
					query:	{
						url: '/api/partidos/:fecha', 
						params: {fecha: '@fecha_id'},	
						method:	'GET',	cache:	false,	isArray:	true
					},
					// save:	{method:	'POST',	cache:	false,	isArray:	false},
					// update:	{method:	'PUT',	cache:	false,	isArray:	false},
					// delete:	{method:	'DELETE',	cache:	false,	isArray:	false}
				}
			);
		}
	]
);

torneoServices.factory('EquiposParticipantes', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/api/torneos/:torneo/equipos/:equipo", 
				{torneo: '@torneo_id',equipo: '@equipo_id'},	
				{
					get:	{method:	'GET',	cache:	false,	isArray:	true},
					save:	{
						url: '/api/equipos_participantes/',
						method:	'POST',	cache:	false,	isArray:	false
					},
					// update:	{method:	'PUT',	cache:	false,	isArray:	false},
					delete:	{method:	'DELETE',	cache:	false,	isArray:	false}
				}
			);
		}
	]
);

torneoServices.factory('JugadoresInscritos', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/api/torneos/:torneo/equipos/:equipo/jugadores", 
				{torneo: '@torneo_id', equipo: '@equipo_id'},	
				{
					get:	{method:	'GET',	cache:	false,	isArray:	true},
					// save:	{method:	'POST',	cache:	false,	isArray:	false},
					// update:	{method:	'PUT',	cache:	false,	isArray:	false},
					// delete:	{method:	'DELETE',	cache:	false,	isArray:	false}
				}
			);
		}
	]
);

torneoServices.factory('Plantillas', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/api/plantillas/:plantilla", 
				{plantilla: '@plantilla_id'},	
				{
					get:	{method:'GET',	cache:false,	isArray:false},
					save:	{method:'POST',	cache:false,	isArray:false},
					update:	{method:'PUT',	cache:false,	isArray:false},
					delete:	{method:'DELETE',	cache:false,	isArray:false},
				}
			);
		}
	]
);

torneoServices.factory('Tablas', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/api/torneos/:torneo/tablas/fases/:fase", 
				{torneo: '@torneo_id',fase: '@fase_id'},	
				{
					query:{
						url: "/api/torneos/:torneo/tablas/", 
						params: {torneo: '@torneo_id'},	
						method:	'GET',	cache:	false,	isArray:	true
					},
					get:{
						// url: "/api/torneos/:torneo/tablas/fases/:fase", 
						// params: {torneo: '@torneo_id',fase: '@fase_id'},	
						method:	'GET',	cache:	false,	isArray:	true
					},
				}
			);
		}
	]
);