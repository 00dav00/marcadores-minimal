(function() {
	'use strict';

	angular
		.module('wizardCliente')
	    .factory('Productos', ApiProductos);

	function ApiProductos($resource) {
		
		var result = {
	        getProductos: getProductos
	    };

	    return result;

	    function getProductos()
	    {
	    	return $resource('/api/productos', { id: '@id' }, {
	            'update': { method: 'PUT' }
	        });
	    }
	}

})();