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

		return $this->golInstance()
						->create($nuevoGol);
	}

	public function obtenerGolesPartido($partido_id) {
		return $this->golInstance()
                    ->with('autor','asistente')
                    ->where('par_id',$partido_id)
                    ->get();
	}
}