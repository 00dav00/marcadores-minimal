(function() {
        'use strict';

        angular
                .module('tablasTorneo')
            .factory('Posiciones', ApiTablas);

        function ApiTablas($resource) {

                var result = {
                getPosiciones: getPosiciones
            };

            return result;

            function getPosiciones()
            {
                return $resource('/api/tablas/:cliente/:torneo',
                        {
                                cliente: '@cliente',
                                torneo: '@torneo' },
                        {
                        'update': { method: 'PUT' }
                });
            }
        }

})();
