(function() {
	'use strict';

	angular
		.module('wizardCliente')
	    .factory('Tablas', ApiTablas);

	function ApiTablas($resource) {
		
		var result = {
	        getTablas: getTablas
	    };

	    return result;

	    function getTablas(cliente_id, torneo_id)
	    {
	    	return $resource('/api/tablas/:cliente_id/:torneo_id', 
	    		{ cliente_id: '@cliente_id', torneo_id: '@torneo_id' },
	    		{ 'query':  { method: 'GET', isArray: false }, 'update': { method: 'PUT' }
	        });
	    }
	}

})();