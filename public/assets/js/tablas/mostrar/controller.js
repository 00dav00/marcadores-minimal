(function() {
        'use strict';

        angular
                .module('tablasTorneo')
                .controller('tablasController', tablasController);

function tablasController(
        toaster,
        exception,
        Posiciones
        )
{

        var tbl = this;

        /**
         * Funciones
         */
        tbl.init = init;
        tbl.mostrarFasePosiciones = mostrarFasePosiciones;
        tbl.cambiarFasePosiciones = cambiarFasePosiciones;

        /**
         * Obtener los valores para mostrar
         */
        function init(idTorneo, idCliente)
        {
                Posiciones.getPosiciones()
                        .get({cliente: idCliente, torneo: idTorneo})
                                .$promise.then(
                                        function(data) {
                                                obtenerInfoCliente(data.cliente);
                                                tbl.torneo = data.torneo;
                                                obtenerInfoFases(data.fases);
                                                tbl.posiciones = data.posiciones;
                                                mostrarFasePosiciones();
                                        }, function (error) {
                                                exception.catcher(error);
                                        }
                        );
        }

        function obtenerInfoCliente(cliente)
        {
                tbl.cliente = cliente;

                if (cliente.personalizacion[0]) {
                        tbl.containerStyle = {
                                "background-color": cliente.personalizacion[0].pva_valor,
                                "color": cliente.personalizacion[4].pva_valor
                        };

                        tbl.headerStyle = {
                                "color": cliente.personalizacion[1].pva_valor
                        };

                        tbl.headerTablaStyle = {
                                "background-color": cliente.personalizacion[2].pva_valor,
                                "color": cliente.personalizacion[3].pva_valor
                        };

                        tbl.botonesStyle = {
                                "background-color": cliente.personalizacion[5].pva_valor,
                                "color": cliente.personalizacion[6].pva_valor,
                        };
                }
        }

        /**
         * Funcion para obtener informacion de las fases
         * y la ultima fase creada
         */
        function obtenerInfoFases(fases)
        {
                tbl.fases = fases;

                var idFaseActual;
                angular.forEach(fases, function(valor, campo) {
                        if (campo != 'acumulada') {
                                idFaseActual = campo;
                        }
                });

                tbl.faseActual = fases[idFaseActual];
        }

        /**
         * Seleccionar las posiciones de que fase se van a mostrar
         */
        function mostrarFasePosiciones()
        {
                tbl.equipos = tbl.posiciones[tbl.faseActual.fas_id];
        }

        function cambiarFasePosiciones(fase)
        {
                tbl.faseActual = fase;

                tbl.equipos = tbl.posiciones[fase.fas_id];
        }

}

})();
