(function() {
	'use strict';

	angular
		.module('wizardCliente')
	    .factory('Clientes', ApiClientes);

	function ApiClientes($resource) {
		
		var result = {
	        getClientes: getClientes
	    };

	    return result;

	    function getClientes()
	    {
	    	return $resource('/api/clientes/:id', { id: '@id' }, {
	            'update': { method: 'PUT' }
	        });
	    }
	}

})();