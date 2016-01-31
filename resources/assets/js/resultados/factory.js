(function() {
	'use strict';

	angular
		.module('resultadosTorneo')
	    .factory('Resultados', ApiResultados);

	function ApiResultados($resource) {
		
		var result = {
	        getInformacionUltimaFecha: getInformacionUltimaFecha,
	        getInformacionFecha: getInformacionFecha
	    };

	    return result;

	    function getInformacionUltimaFecha()
	    {
	    	return $resource('/api/resultados/:cliente/:torneo', 
	    		{ 
	    			cliente: '@cliente', 
	    			torneo: '@torneo' }, 
	    		{
	            	'update': { method: 'PUT' }
	        });
	    }

	    function getInformacionFecha()
	    {
	    	return $resource('/api/resultados/:cliente/:torneo/:fase/:fecha', 
	    		{ 
	    			cliente: '@cliente', 
	    			torneo: '@torneo',
	    			fase: '@fase',
	    			fecha: '@fecha' }, 
	    		{
	            	'update': { method: 'PUT' }
	        });
	    }
	}

})();