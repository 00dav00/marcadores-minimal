(function() {
    'use strict';

    angular
        .module('wizardTorneo')
        .config(config)

function config($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
}
        
})();