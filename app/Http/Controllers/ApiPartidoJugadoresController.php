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

    public function ingresarJugadorTitular(PartidoJugadorTitularRequest $request) {
        $partidoJugador = $request->all();
        $partidoJugador['pju_minuto_ingreso'] = 0;

        return $this->store($partidoJugador);
    }

    public function obtenerJugadoresTitulares($partido_id, $equipo_id) {
        return  $this->domainInstance()
                        ->obtenerJugadoresTitulares($partido_id, $equipo_id)
                        ->toJson();
    }

    public function obtenerJugadoresDisponibilidad($partido_id) {
        $partido = $this->partidoInstance()->find($partido_id);

        $jugadoresLocal = $this->domainInstance()
                                ->obtenerJugadoresDisponibilidad($partido_id, $partido->par_eqp_local);
        $jugadoresVisitante = $this->domainInstance()
                                    ->obtenerJugadoresDisponibilidad($partido_id, $partido->par_eqp_visitante);

        return collect(['local' => $jugadoresLocal, 'visitante' => $jugadoresVisitante])->toJson();
    }

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
                $titulares[] = $this->partidoJugadorInstance(true)->fill($titular); // true forza a crear un nuevo objecto
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
                    ->map(function ($item) { return $item->jugador; })
                    ->toJson();
    }

    public function ingresarJugadorCambio(PartidoJugadorCambioRequest $request) {
        $data = $request->all();
        $partidoJugadorActual = $this->_partidoJugador
                                        ->find($data['pju_reemplazo_de'])
                                        ->update(['pju_minuto_salida' => $data['pju_minuto_ingreso']]);

        return $this->store($data);
    }

    private function store($atributos) {
        $contador = $this->_partidoJugador
                            ->where('par_id', $atributos['par_id'])
                            ->where('jug_id', $atributos['jug_id'])
                            ->count();
        if($contador > 0)
            return \Response::make(null, 400);

        $partidoJugador = $this->_partidoJugador->create($atributos);

        return $partidoJugador->toJson();
    }

    public function show($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        $partidoJugador = $this->_partidoJugador->find($id);
        
        if(!isset($partidoJugador))
            return \Response::make(null, 404);

        $partidoJugador->delete();
        return \Response::make(null, 200);
    }
}
