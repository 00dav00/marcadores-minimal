<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PartidoJugador;
use App\Domain\DomJugadorPartido;
use App\Partido;
use App\Http\Requests\PartidoJugadorTitularRequest;
use App\Http\Requests\PartidoJugadorCambioRequest;

class ApiPartidoJugadoresController extends Controller
{
    protected $_partido;
    protected $_partidoJugador;
    protected $_domainPartidoJugador;

    public function __construct(PartidoJugador $partidoJugador) {
        $this->_partidoJugador = $partidoJugador;
    }

    /****************** WRAPPERS PARA CLASES **************************/
    private function domainInstance() {
        if (!$this->_domainPartidoJugador) {
            $this->_domainPartidoJugador = new DomJugadorPartido;
        }
        return $this->_domainPartidoJugador;
    }

    private function partidoInstance() {
        if (!$this->_partido) {
            $this->_partido = new Partido;
        }
        return $this->_partido;
    }
    private function partidoJugadorInstance($force) {
        if ( !$this->_partidoJugador || $force) {
            $this->_partidoJugador = new PartidoJugador;
        }
        return $this->_partidoJugador;
    }

    /****************** WRAPPERS PARA CLASES **************************/

    public function obtenerJugadoresDisponibilidad($partido_id) {
        $partido = $this->partidoInstance()->find($partido_id);

        $jugadoresLocal = $this->domainInstance()
                                ->obtenerJugadoresDisponibilidad($partido_id, $partido->par_eqp_local);
        $jugadoresVisitante = $this->domainInstance()
                                    ->obtenerJugadoresDisponibilidad($partido_id, $partido->par_eqp_visitante);

        return collect(['local' => $jugadoresLocal, 'visitante' => $jugadoresVisitante])->toJson();
    }

    /****************** TITUTLARES **************************/    
    public function ingresarJugadoresTitulares(Request $request, $partido_id, $equipo_id) {
        $titulares = [];
        $errors = [];

        foreach($request->all() as $jugador)
        {
            $titular = array(
                'par_id' => $partido_id,
                'jug_id' => $jugador['jug_id'],
                'pju_juvenil' => false,
                'pju_minuto_ingreso' => 0,
                'eqp_id' => $equipo_id,
            );

            $validator = Validator::make($titular, PartidoJugadorTitularRequest::$rules, PartidoJugadorTitularRequest::$messages);

            if ($validator->passes()) {
                $titulares[] = $this->partidoJugadorInstance(true)->fill($titular); // true forza a crear un nuevo objeto
            }
            else {
                foreach ($validator->errors() as $key => $value) {
                    foreach ($value as $message) {
                        $errors[] = $jugador->jug_nombre.''.$jugador->jug_apellido.': '.$value;
                    }
                }
            }
        }

        if (count($errors) > 0)
             return \Response::make($errors, 422);

        if (! $this->domainInstance()->ingresarJugadoresTitulares($titulares, $partido_id, $equipo_id) )
             return \Response::make(null, 500);

        return $this->domainInstance()
                    ->obtenerJugadoresTitulares($partido_id, $equipo_id)
                    ->toJson();
    }

    public function obtenerJugadoresTitulares($partido_id, $equipo_id) {
        return  $this->domainInstance()
                        ->obtenerJugadoresTitulares($partido_id, $equipo_id)
                        ->toJson();
    }

    /****************** SUSTITUCIONES **************************/
    public function ingresarSustitucion(PartidoJugadorCambioRequest $request) {
        return $this->domainInstance()
                    ->ingresarSustitucion( $request->all() );
    }

    public function eliminarSustitucion($sustitucion_id) {
        if ( !$this->domainInstance()->eliminarSustitucion($sustitucion_id) ) {
            return \Response::make(null, 500);
        }

        return \Response::make(null, 200);
    }
}
