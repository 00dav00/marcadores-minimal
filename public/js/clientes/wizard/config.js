(function() {
    'use strict';

    angular
        .module('wizardCliente')
        .config(config)

	function config($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	}
        
})();