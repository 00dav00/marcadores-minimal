<?php

namespace App\Domain;

use App\PartidoJugador;
use App\Equipo;
use App\Partido;

class DomJugadorPartido {

    protected $_partidoJugador;
    protected $_equipo;
	protected $_partido;

    /****************** WRAPPERS PARA CLASES **************************/
    private function partidoJugadorInstance() {
        if (!$this->_partidoJugador) {
            $this->_partidoJugador = new PartidoJugador;
        }
        return $this->_partidoJugador;
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
    

    public function obtenerJugadoresTitulares($partido_id, $equipo_id) {
    	return $this->partidoJugadorInstance()
    					->with('jugador')
                        ->where('par_id', $partido_id)
                        ->where('eqp_id', $equipo_id)
                        ->where('pju_minuto_ingreso', 0)
                        ->get();                        	
    }

    public function obtenerJugadoresCambio($partido_id, $equipo_id) {
    	return  $this->partidoJugadorInstance()
						->with('jugador')
                    	->where('par_id', $partido_id)
                    	->where('eqp_id', $equipo_id)
                    	->where('pju_minuto_ingreso', '!=', 0)
                        ->whereNotNull('pju_reemplazo_de')
                    	->whereNotNull('pju_minuto_ingreso')
                    	->get();                        	
    }

    public function obtenerJugadoresSustituidos($partido_id, $equipo_id) {
    	return  $this->partidoJugadorInstance()
						->with('jugador')
                    	->where('par_id', $partido_id)
                    	->where('eqp_id', $equipo_id)
                    	->whereNotNull('pju_minuto_ingreso')
                    	->whereNotNull('pju_minuto_salida')
                    	->get();                        	
    }

    public function obtenerJugadoresEnCancha($partido_id, $equipo_id) {
    	$jugadoresPartido = $this->partidoJugadorInstance()
									->with('jugador')
                    				->where('par_id', $partido_id)
                    				->where('eqp_id', $equipo_id)
                    				->whereNotNull('pju_minuto_ingreso')
                    				->whereNull('pju_minuto_salida')
                    				->get();

        $jugadores = $jugadoresPartido->map(function ($item) { return $item->jugador; });

		return $jugadores;
    }

    public function obtenerJugadoresDisponibilidad($partido_id, $equipo_id) {
        $torneo = $this->partidoInstance()
                            ->find($partido_id)
                            ->fecha()->get()->first()
                            ->fase()->get()->first()
                            ->torneo()->get()->first();

        $plantilla = $this->equipoInstance()
                            ->find($equipo_id)
                            ->plantillas()
                            ->wherePivot('tor_id',$torneo->tor_id)
                            ->get();

        $titulares = $this->obtenerJugadoresTitulares($partido_id, $equipo_id)
                                ->map(function ($item) { return $item->jugador; });

        $jugadoresEnCancha = $this->obtenerJugadoresEnCancha($partido_id, $equipo_id);

        $jugadoresSustituidos = $this->obtenerJugadoresSustituidos($partido_id, $equipo_id)
                                        ->map(function ($item) { return $item->jugador; });

        $jugadoresNoDisponibles = $jugadoresEnCancha->merge($jugadoresSustituidos);

        $jugadoresDisponibles = $plantilla->filter(
            function ($item) use ($jugadoresNoDisponibles) {
                $disponible = true;
                foreach ($jugadoresNoDisponibles as $jugador) {
                    if ($jugador->jug_id == $item->jug_id) $disponible = false;
                }                
                return $disponible; 
        })->values();

        return collect([
            'plantilla' => $plantilla,
            'titulares' => $titulares,
            'en_cancha' => $jugadoresEnCancha, 
            'sustituciones' => $jugadoresSustituidos, 
            'disponibles' => $jugadoresDisponibles
        ]);
    }

    public function ingresarJugadoresTitulares($jugadores, $partido_id, $equipo_id) {
        $jugadoresNuevos = collect($jugadores);
        $titulares = $this->obtenerJugadoresTitulares($partido_id, $equipo_id);

        if ($titulares) {
            $titulares = $titulares
                            ->map(function ($titular) use ($jugadoresNuevos) { 
                                if ( !$jugadoresNuevos->contains('jug_id', $titular->jug_id) ) {
                                    $titular->delete();
                                    $titular = null;
                                }
                                return $titular; 
                            });

            $jugadoresNuevos = $jugadoresNuevos
                                    ->filter(function ($j) use ($titulares) { return !$titulares->contains('jug_id', $j->jug_id); })
                                    ->values();
        }


        return $this->partidoJugadorInstance()
                    ->insert($jugadoresNuevos->toArray());
    }

    public function ingresarCambio($jugadorCambio) {
        $this->partidoJugadorInstance()
                ->find($jugadorCambio['pju_reemplazo_de'])
                ->update(['pju_minuto_salida' => $jugadorCambio['pju_minuto_ingreso']]);

        return $this->_partidoJugador->store($data);
    }
}