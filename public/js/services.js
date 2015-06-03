'use strict';
/*	Services	*/
var	torneoServices = angular.module('torneoServices', ['ngResource']);

torneoServices.factory(
	'EquiposParticipantes', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/torneos/:torneo/equipos", 
				{torneo: '@torneo_id'},	
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

torneoServices.factory(
	'JugadoresInscritos', 
	[
		'$resource',
		function($resource)	{
			return	$resource(
				"/torneos/:torneo/equipos/:equipo", 
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


torneoServices.factory(
	'Plantillas', 
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