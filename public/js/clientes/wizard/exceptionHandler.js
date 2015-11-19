(function() {
	'use strict';

angular
    .module('wizardCliente')
    .factory('exception', exception);

exception.$inject = ['toaster'];

function exception(toaster) {
    var service = {
        catcher: catcher
    };
    return service;

    function catcher(message) {
    	toaster.pop('error', "Error", "Se ha producido el siguiente error: " + message.statusText);
    }
}

})();