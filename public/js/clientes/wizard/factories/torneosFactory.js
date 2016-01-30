(function() {
	'use strict';

	angular
		.module('wizardCliente')
	    .factory('Torneos', ApiTorneos);

	function ApiTorneos($resource) {
		
		var result = {
	        getTorneos: getTorneos
	    };

	    return result;

	    function getTorneos()
	    {
	    	return $resource('/api/torneos');
	    }
	}

})();