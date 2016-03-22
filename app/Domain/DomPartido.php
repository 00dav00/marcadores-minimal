<?php

namespace App\Domain;

use App\Partido;

use App\Domain\DomGol;
use App\Domain\DomJugadorPartido;
use App\Domain\DomAmonestacion;

class DomPartido {

    protected $_amonestacion;
    protected $_partidoJugador;
    protected $_partido;
    protected $_gol;

/****************** WRAPPERS PARA CLASES **************************/
    private function partidoInstance() {
        if (!$this->_partido) {
            $this->_partido = new Partido;
        }
        return $this->_partido;
    }

    private function domainPartidoJugadorInstance() {
        if (!$this->_partidoJugador) {
            $this->_partidoJugador = new DomJugadorPartido;
        }
        return $this->_partidoJugador;
    }

    private function domainAmonestacionInstance() {
        if (!$this->_amonestacion) {
            $this->_amonestacion = new DomAmonestacion;
        }
        return $this->_amonestacion;
    }

    private function domainGolInstance() {
        if (!$this->_gol) {
            $this->_gol = new DomGol;
        }
        return $this->_gol;
    }

/****************** WRAPPERS PARA CLASES **************************/

    public function obtenerEstado($partido_id) {
        $partido = $this->partidoInstance()->find($partido_id);

        $jugadoresLocal = $this->domainPartidoJugadorInstance()
                                ->obtenerJugadoresDisponibilidad($partido_id, $partido->par_eqp_local);
        $jugadoresVisitante = $this->domainPartidoJugadorInstance()
                                    ->obtenerJugadoresDisponibilidad($partido_id, $partido->par_eqp_visitante);

        $golesLocal = $this->domainGolInstance()
                                ->obtenerGolesEquipoPartido($partido_id, $partido->par_eqp_local);
        $golesVisitante = $this->domainGolInstance()
                                ->obtenerGolesEquipoPartido($partido_id, $partido->par_eqp_visitante);

        $amonestacionesLocal = $this->domainAmonestacionInstance()
                                        ->obtenerAmonestacionesPartidoEquipo($partido_id, $partido->par_eqp_local);
        $amonestacionesVisitante = $this->domainAmonestacionInstance()
                                        ->obtenerAmonestacionesPartidoEquipo($partido_id, $partido->par_eqp_visitante);


        $acciones = $jugadoresLocal->get('sustituciones')->count();
        $acciones += $jugadoresVisitante->get('sustituciones')->count();
        $acciones += $golesLocal->count();
        $acciones += $golesVisitante->count();
        $acciones += $amonestacionesLocal->count();
        $acciones += $amonestacionesVisitante->count();

        
        return collect([
            'iniciado' => $acciones > 1,
            'local' => [
                'plantilla' => $jugadoresLocal->get('plantilla'),
                'titulares' => $jugadoresLocal->get('titulares'),
                'en_cancha' => $jugadoresLocal->get('en_cancha'),
                'sustituciones' => $jugadoresLocal->get('sustituciones'),
                'disponibles' => $jugadoresLocal->get('disponibles'),
                'goles' => $golesLocal,
                'amonestaciones' => $amonestacionesLocal,
            ], 
            'visitante' => [
                'plantilla' => $jugadoresVisitante->get('plantilla'),
                'titulares' => $jugadoresVisitante->get('titulares'),
                'en_cancha' => $jugadoresVisitante->get('en_cancha'),
                'sustituciones' => $jugadoresVisitante->get('sustituciones'),
                'disponibles' => $jugadoresVisitante->get('disponibles'),
                'goles' => $golesVisitante,
                'amonestaciones' => $amonestacionesVisitante,
            ]

        ]);
    }

}