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
    <div class="col-xs-3 eventButton col-centered btn-success btn-lg" ng-click="openModal('goles.tpl')">
        <p class="buttonContent">Goles</p>
    </div>

    <div class="col-xs-3 eventButton col-centered btn-info btn-lg" ng-click="openModal('cambios.tpl')">
        <p class="buttonContent">Cambios</p>
    </div>

    <div class="col-xs-3 eventButton col-centered btn-warning btn-lg" ng-click="openModal('amonestaciones.tpl')">
        <p class="buttonContent">Amonestaciones</p>
    </div>
</div>

<div class="row">
    <div class="col-xs-10 col-md-6 col-lg-6">
        <div><b>Goles de: <% partidoSeleccionado.equipo_local.eqp_nombre %></b></div>
        <table class="table-striped">
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Asistente</th>
                    <th>Min.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="gol in goles.local">
                    <td><% gol.autor.jug_nombre %> <% gol.autor.jug_apellido %></td>
                    <td><% gol.asistente.jug_nombre %> <% gol.asistente.jug_apellido %></td>
                    <td><% gol.gol_minuto %></td>
                    <td>
                        <button class="btn btn-info btn-xs" ng-click="">  
                            <span class="glyphicon glyphicon-edit" ></span>
                        </button>
                        <button class="btn btn-danger btn-xs" ng-click="">  
                            <span class="glyphicon glyphicon-trash" ></span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-xs-10 col-md-6 col-lg-6">
        <div><b>Goles de: <% partidoSeleccionado.equipo_visitante.eqp_nombre %></b></div>
        <table class="table-striped">
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Asistente</th>
                    <th>Min.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="gol in goles.visitante">
                    <td><% gol.autor.jug_nombre %> <% gol.autor.jug_apellido %></td>
                    <td><% gol.asistente.jug_nombre %> <% gol.asistente.jug_apellido %></td>
                    <td><% gol.gol_minuto %></td>
                    <td>
                        <button class="btn btn-info btn-xs" ng-click="">  
                            <span class="glyphicon glyphicon-edit" ></span>
                        </button>
                        <button class="btn btn-danger btn-xs" ng-click="">  
                            <span class="glyphicon glyphicon-trash" ></span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<div>