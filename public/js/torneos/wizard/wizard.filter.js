(function() {
    'use strict';

    angular
        .module('wizardTorneo')
        .filter('filtroCheckbox', function() {
        	return function (item) {
        		if (item === 1) {
        			return "Si"
        		} else {
        			return "No"
        		}
        	}
        })
        
})();