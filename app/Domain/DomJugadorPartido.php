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

    public function ingresarSustitucion($sustitucion) {
        $sustituido = $this->partidoJugadorInstance()
                            ->where('par_id', $sustitucion['par_id'])
                            ->where('jug_id', $sustitucion['pju_reemplazo_de'])
                            ->get()->first();

        $sustituido->pju_minuto_salida = $sustitucion['pju_minuto_ingreso'];
        $sustitucion['pju_reemplazo_de'] = $sustituido->pju_id;

        $sustituido->save();

        return $this->_partidoJugador->create($sustitucion);
    }

    public function editarSustitucion($sustitucion_id, $sustitucion) {
        $ingresoOriginal = $this->partidoJugadorInstance()
                                ->find($sustitucion_id);
        $sustituidoOriginal = $this->partidoJugadorInstance()
                                    ->find( $ingresoOriginal->pju_minuto_ingreso );

        $sustituidoNuevo = $this->partidoJugadorInstance()
                                ->where('par_id', $sustitucion['par_id'])
                                ->where('jug_id', $sustitucion['pju_reemplazo_de'])
                                ->get()->first();

        $ingresoOriginal->par_id = $sustitucion['par_id'];
        $ingresoOriginal->jug_id = $sustitucion['jug_id'];
        $ingresoOriginal->eqp_id = $sustitucion['eqp_id'];
        $ingresoOriginal->pju_minuto_ingreso = $sustitucion['pju_minuto_ingreso'];

        if ( $sustituidoOriginal->pju_id != $sustituidoNuevo->pju_id ) {
            $ingresoOriginal->pju_reemplazo_de = $sustituidoNuevo->pju_id;
            $sustituidoOriginal->pju_minuto_salida = null;
            $sustituidoOriginal->dave();
        }

        return $ingresoOriginal->save();
    }

    public function eliminarSustitucion($sustitucion_id) {
        $sustitucion = $this->partidoJugadorInstance()
                            ->find($sustitucion_id);

        $sustitucion->find($sustitucion['pju_reemplazo_de'])
                    ->update(['pju_minuto_salida' => null]);

        return $sustitucion->delete();
    }

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
						->with('jugador','sustituido')
                    	->where('par_id', $partido_id)
                    	->where('eqp_id', $equipo_id)
                    	->where('pju_minuto_ingreso', '!=', 0)
                        ->whereNotNull('pju_reemplazo_de')
                    	->whereNotNull('pju_minuto_ingreso')
                    	->get();                        	
    }

    public function obtenerJugadoresSustituidos($partido_id, $equipo_id) {
    	$partidoJugador =  $this->partidoJugadorInstance()
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

        $jugadoresCambio = $this->obtenerJugadoresCambio($partido_id, $equipo_id);

        $jugadoresSustituidos = $jugadoresCambio->map(function ($item) { return $item->sustituido; });

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
            'sustituciones' => $jugadoresCambio, 
            'disponibles' => $jugadoresDisponibles
        ]);
    }
}