<style>
    .eventButton {
        /*width: 150px;*/
        height: 125px;
        moz-border-radius: 15px;
        -webkit-border-radius: 15px;
        line-height: 125px;
        
        margin: 20px;
        display: table;
        table-layout: fixed;
        text-align: center !important;
    }

    .buttonContent{
        /*text-align: center;
        display: table-cell !important;
        vertical-align: middle;*/
        text-align: center !important;
        display: inline-block;
        vertical-align: middle;
        line-height: normal;
    }

    .row-centered {
        text-align: center;
    }
    .col-centered {
        display:inline-block;
        float:none;
        /* reset the text-align */
        text-align:left;
        /* inline-block space fix */
        margin-right:-4px;
    }
</style>

<div class="row row-centered">    
    <div class="col-xs-3 eventButton col-centered btn-success btn-lg" ng-click="golIngresar()">
        <p class="buttonContent">Goles</p>
    </div>

    <div class="col-xs-3 eventButton col-centered btn-info btn-lg" ng-click="sustitucionIngresar()">
        <p class="buttonContent">Cambios</p>
    </div>

    <div class="col-xs-3 eventButton col-centered btn-warning btn-lg" ng-click="amonestacionIngresar()">
        <p class="buttonContent">Amonestaciones</p>
    </div>
</div>

<div class="panel-group">
    
    <div class="panel panel-default" ng-hide="goles.local.length + goles.visitante.length == 0">
        <div class="panel-heading">
            <h4 class="text-center"><b>Goles</b></h4>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="text-center"><b><% partidoSeleccionado.equipo_local.eqp_nombre %></b></div>
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Autor</th>
                            <th class="text-center">Asistente</th>
                            <th class="text-center">Min.</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="gol in goles.local">
                            <td class="col-xs-4 col-md-2 col-lg-2"><% gol.autor.jug_nombre %> <% gol.autor.jug_apellido %></td>
                            <td class="col-xs-4 col-md-2 col-lg-2"><% gol.asistente.jug_nombre %> <% gol.asistente.jug_apellido %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1"><% gol.gol_minuto %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1">
                                <button class="btn btn-info btn-xs" ng-click="golEditar(gol)">
                                    <span class="glyphicon glyphicon-edit" ></span>
                                </button>
                                <button class="btn btn-danger btn-xs" ng-click="golEliminar(gol)">
                                    <span class="glyphicon glyphicon-trash" ></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-10 col-md-6 col-lg-6">
                <div class="text-center"><b><% partidoSeleccionado.equipo_visitante.eqp_nombre %></b></div>
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Autor</th>
                            <th class="text-center">Asistente</th>
                            <th class="text-center">Min.</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="gol in goles.visitante">
                            <td class="col-xs-4 col-md-2 col-lg-2"><% gol.autor.jug_nombre %> <% gol.autor.jug_apellido %></td>
                            <td class="col-xs-4 col-md-2 col-lg-2"><% gol.asistente.jug_nombre %> <% gol.asistente.jug_apelresources/views/partidos/partials/eventos.blade.phplido %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1"><% gol.gol_minuto %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1">
                                <button class="btn btn-info btn-xs" ng-click="golEditar(gol)">
                                    <span class="glyphicon glyphicon-edit" ></span>
                                </button>
                                <button class="btn btn-danger btn-xs" ng-click="golEliminar(gol)">
                                    <span class="glyphicon glyphicon-trash" ></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-default" ng-hide="sustituciones.local.length + sustituciones.visitante.length == 0">
        <div class="panel-heading">
            <h4 class="text-center"><b>Sustituciones</b></h4>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="text-center"><b><% partidoSeleccionado.equipo_local.eqp_nombre %></b></div>
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Ingresa</th>
                            <th class="text-center">Sale</th>
                            <th class="text-center">Minuto</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="sustitucion in sustituciones.local">
                            <td class="col-xs-4 col-md-2 col-lg-2"><% sustitucion.jugador.jug_nombre %> <% sustitucion.jugador.jug_apellido %></td>
                            <td class="col-xs-4 col-md-2 col-lg-2"><% sustitucion.sustituido.jugador.jug_nombre %> <% sustitucion.sustituido.jugador.jug_apellido %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1"><% sustitucion.pju_minuto_ingreso %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1">
                                <button class="btn btn-danger btn-xs" ng-click="sustitucionEliminar(sustitucion)"
                                    ng-disabled="$index + 1 < sustituciones.local.length">
                                    <span class="glyphicon glyphicon-trash" ></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-10 col-md-6 col-lg-6">
                <div class="text-center"><b><% partidoSeleccionado.equipo_visitante.eqp_nombre %></b></div>
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Ingresa</th>
                            <th class="text-center">Sale</th>
                            <th class="text-center">Minuto</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="sustitucion in sustituciones.visitante">
                            <td class="col-xs-4 col-md-2 col-lg-2"><% sustitucion.jugador.jug_nombre %> <% sustitucion.jugador.jug_apellido %></td>
                            <td class="col-xs-4 col-md-2 col-lg-2"><% sustitucion.sustituido.jugador.jug_nombre %> <% sustitucion.sustituido.jugador.jug_apellido %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1"><% sustitucion.pju_minuto_ingreso %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1">
                                <button class="btn btn-danger btn-xs" ng-click="sustitucionEliminar(sustitucion)"
                                    ng-disabled="$index + 1 < sustituciones.visitante.length">
                                    <span class="glyphicon glyphicon-trash" ></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="panel panel-default" ng-hide="amonestaciones.local.length + amonestaciones.visitante.length == 0">
        <div class="panel-heading">
            <h4 class="text-center"><b>Amonestaciones</b></h4>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div class="text-center"><b><% partidoSeleccionado.equipo_local.eqp_nombre %></b></div>
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Jugador</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Minuto</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="amonestacion in amonestaciones.local">
                            <td class="col-xs-4 col-md-2 col-lg-2"><% amonestacion.jugador.jug_nombre %> <% amonestacion.jugador.jug_apellido %></td>
                            <td class="col-xs-4 col-md-2 col-lg-2"><% amonestacion.amn_tipo %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1"><% amonestacion.amn_minuto %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1">
                                <button class="btn btn-info btn-xs" ng-click="amonestacionEditar(amonestacion)">
                                    <span class="glyphicon glyphicon-edit" ></span>
                                </button>
                                <button class="btn btn-danger btn-xs" ng-click="amonestacionEliminar(amonestacion)"
                                    ng-disabled="$index + 1 < amonestaciones.local.length">
                                    <span class="glyphicon glyphicon-trash" ></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-10 col-md-6 col-lg-6">
                <div class="text-center"><b><% partidoSeleccionado.equipo_visitante.eqp_nombre %></b></div>
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Jugador</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Minuto</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="amonestacion in amonestaciones.visitante">
                            <td class="col-xs-4 col-md-2 col-lg-2"><% amonestacion.jugador.jug_nombre %> <% amonestacion.jugador.jug_apellido %></td>
                            <td class="col-xs-4 col-md-2 col-lg-2"><% amonestacion.amn_tipo %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1"><% amonestacion.amn_minuto %></td>
                            <td class="col-xs-2 col-md-1 col-lg-1">
                                <button class="btn btn-info btn-xs" ng-click="amonestacionEditar(amonestacion)">
                                    <span class="glyphicon glyphicon-edit" ></span>
                                </button>
                                <button class="btn btn-danger btn-xs" ng-click="amonestacionEliminar(amonestacion)"
                                    ng-disabled="$index + 1 < amonestaciones.visitante.length">
                                    <span class="glyphicon glyphicon-trash" ></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
