(function() {
	'use strict';

	angular
		.module('tablasTorneo')
	    .factory('Goleadores', ApiTablas);

	function ApiTablas($resource) {
		
		var result = {
	        getGoleadores: getGoleadores
	    };

	    return result;

	    function getGoleadores()
	    {
	    	return $resource('/api/goleadores/:cliente/:torneo', 
	    		{ 
	    			cliente: '@cliente', 
	    			torneo: '@torneo' }, 
	    		{
	            	'update': { method: 'PUT' }
	        });
	    }
	}

})();