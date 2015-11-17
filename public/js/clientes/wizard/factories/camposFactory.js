(function() {
	'use strict';

	angular
		.module('wizardCliente')
	    .factory('Campos', ApiClientes);

	function ApiClientes($resource) {
		
		var result = {
	        getCampos: getCampos
	    };

	    return result;

	    function getCampos()
	    {
	    	return $resource('/api/personalizacion_campos', { id: '@id' }, {
	            'update': { method: 'PUT' }
	        });
	    }
	}

})();