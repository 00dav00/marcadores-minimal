<?php

namespace App\Domain;

use App\PartidoGol;
use App\Equipo;
use App\Partido;
use App\Jugador;

class DomGol {

	protected $_gol;
	protected $_jugador;
	protected $_partido;
    protected $_equipo;


 /****************** WRAPPERS PARA CLASES **************************/
    private function golInstance() {
        if (!$this->_gol) {
            $this->_gol = new PartidoGol;
        }
        return $this->_gol;
    }

    private function jugadorInstance() {
    	if (!$this->_jugador) {
    		$this->_jugador = new Jugador;
    	}
    	return $this->_jugador;
    }

    private function equipoInstance() {
    	if (!$this->_equipo) {
    		$this->_equipo = new Equipo;
    	}
    	return $this->_equipo;
    }

    private function partidoInstance() {
        if (!$this->_partido) {
            $this->_partido = new Partido;
        }
        return $this->_partido;
    }

/****************** WRAPPERS PARA CLASES **************************/

    private function esAutogol($nuevoGol) {
		$partido = $this->partidoInstance()->find($nuevoGol['par_id']);

		$equipoBeneficiado = $nuevoGol['eqp_id'];
		$equipoAutor = $partido->jugadoresParticipantes()->get()
						->filter(function ($item) use ($nuevoGol) { return $item["jug_id"] == $nuevoGol["gol_autor"]; })
						->first()->pivot->eqp_id;

		return $equipoBeneficiado != $equipoAutor;
	}

	public function ingresarGol($nuevoGol) {
		
		if ($this->esAutogol($nuevoGol)) {
			$nuevoGol['gol_auto'] = true;
			$nuevoGol['gol_jugada'] = null;
			$nuevoGol['gol_ejecucion'] = null;
			$nuevoGol['gol_asistencia'] = null;
		}

		$gol = $this->golInstance()->create($nuevoGol);
        $this->actualizarGolesPartido($nuevoGol['par_id']);

        return $gol;
	}

	public function obtenerGolesPartido($partido_id) {
		return $this->golInstance()
                    ->with('autor','asistente')
                    ->where('par_id',$partido_id)
                    ->get();
	}

    public function obtenerGolesEquipoPartido($partido_id, $equipo_id) {
        return $this->obtenerGolesPartido($partido_id)
                        ->filter(function ($gol) use($equipo_id) { return $gol->eqp_id == $equipo_id; })->values();
    }

    public function actualizarGolesPartido($partido_id) {
        $partido = $partido = $this->partidoInstance()->find($partido_id);
        $goles = $partido->goles()->get();

        $local = $goles->filter(
            function ($item) use ($partido) {
                return $item->eqp_id == $partido->par_eqp_local;
        })->values()->count();
        $visitante = $goles->filter(
            function ($item) use ($partido) {
                return $item->eqp_id == $partido->par_eqp_visitante;
        })->values()->count();

        $partido->par_goles_local = $local;
        $partido->par_goles_visitante = $visitante;
        $partido->save();
    }
}