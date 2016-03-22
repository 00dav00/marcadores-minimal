<?php

namespace App\Domain;

use App\Amonestacion;
use App\Partido;
use App\PartidoJugador;


class DomAmonestacion {

    protected $_amonestacion;
    protected $_partido;
    protected $_jugadorPartido;

/****************** WRAPPERS PARA CLASES **************************/
    private function amonestacionInstance() {
        if (!$this->_amonestacion) {
            $this->_amonestacion = new Amonestacion;
        }
        return $this->_amonestacion;
    }

    private function partidoInstance() {
        if (!$this->_partido) {
            $this->_partido = new Partido;
        }
        return $this->_partido;
    }

    private function jugadorPartidoInstance() {
        if (!$this->_jugadorPartido) {
            $this->_jugadorPartido = new PartidoJugador;
        }
        return $this->_jugadorPartido;
    }
/****************** WRAPPERS PARA CLASES **************************/

    public function ingresarAmonestacion( $amonestacion ) {
        $amonestaciones = $this->obtenerAmonestaciones($amonestacion['par_id'], $amonestacion['jug_id']);

        $amarillas = $amonestaciones->filter(function ($a) { return $a->amn_tipo == 'amarilla'; })->values();
        $rojas = $amonestaciones->filter(function ($a) { return $a->amn_tipo == 'roja'; })->values();

        if ($rojas->count() > 0 || $amarillas->count() > 1)  {
            return null;
        }

        $this->verificarExpulsion($amonestaciones, $amonestacion);

        return $this->amonestacionInstance()->create($amonestacion);
    }

    private function obtenerAmonestaciones($partido_id, $jugador_id) {
        return $this->amonestacionInstance()
                        ->where('par_id', $partido_id)
                        ->where('jug_id', $jugador_id)
                        ->get();
    }

    public function obtenerAmonestacionesPartidoEquipo($partido_id, $equipo_id) {
        return $this->amonestacionInstance()
                        ->with('jugador')
                        ->where('par_id', $partido_id)
                        ->where('eqp_id', $equipo_id)
                        ->get();
    }

    public function actualizarAmonestacion($amonestacion_id, $amonestacion_minuto) {

        $amonestacion = $this->amonestacionInstance()->find($amonestacion_id);

        if (!$amonestacion) return null;

        $amonestacion->amn_minuto = $amonestacion_minuto;
        $amonestacion->save();
        
        return true;
    }


    public function eliminarAmonestacion($amonestacion_id) {

        $amonestacion = $this->amonestacionInstance()->find($amonestacion_id);

        if (!$amonestacion) return null;

        $amonestacion->delete();

        $amonestaciones = $this->obtenerAmonestaciones($amonestacion->par_id, $amonestacion->jug_id);
        $this->verificarRetiroExpulsion($amonestaciones, $amonestacion);
        
        return true;
    }

    /******************* CANDIDATOS PARA MOVER EN REFACTOR ********************************/

    private function verificarExpulsion($amonestacionesPrevias, $amonestacionNueva) {
        $amarillas = $amonestacionesPrevias->filter(function ($a) { return $a->amn_tipo == 'amarilla'; })->values()->count();

        if ($amonestacionNueva['amn_tipo'] == 'roja' || 
            ($amonestacionNueva['amn_tipo'] == 'amarilla' && $amarillas > 0)) {
            $jugador = $this->jugadorPartidoInstance()
                            ->where('par_id', $amonestacionNueva['par_id'])
                            ->where('jug_id', $amonestacionNueva['jug_id'])
                            ->get()->first();

            $jugador->pju_minuto_salida = $amonestacionNueva['amn_minuto'];
            $jugador->save();
        }
    }

    private function verificarRetiroExpulsion($amonestacionesPrevias, $amonestacionNueva) {
        $amarillas = $amonestacionesPrevias->filter(function ($a) { return $a->amn_tipo == 'amarilla'; })->values()->count();

        if ($amonestacionNueva['amn_tipo'] == 'roja' || 
            ($amonestacionNueva['amn_tipo'] == 'amarilla' && $amarillas == 1)) {
            $jugador = $this->jugadorPartidoInstance()
                            ->where('par_id', $amonestacionNueva['par_id'])
                            ->where('jug_id', $amonestacionNueva['jug_id'])
                            ->get()->first();

            $jugador->pju_minuto_salida = null;
            $jugador->save();
        }
    }    

}