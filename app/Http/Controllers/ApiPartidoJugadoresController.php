<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PartidoJugador;
use App\Partido;
use App\Http\Requests\PartidoJugadorTitularRequest;
use App\Http\Requests\PartidoJugadorCambioRequest;

class ApiPartidoJugadoresController extends Controller
{
    protected $partidoJugador;

    public function __construct(PartidoJugador $partidoJugador)
    {
        $this->partidoJugador = $partidoJugador;
    }

    public function ingresarJugadorTitular(PartidoJugadorTitularRequest $request)
    {
        $partidoJugador = $request->all();
        $partidoJugador['pju_minuto_ingreso'] = 0;

        return $this->store($partidoJugador);
    }

    public function obtenerJugadoresTitulares($partido_id)
    {
        return Partido::findOrfail($partido_id)->titulares->toJson();
    }

    public function ingresarJugadoresTitulares(Request $request, $partido_id)
    {
        $titulares = [];
        $errors = [];

        foreach($request->all() as $jugador)
        {
            $titular = array(
                'par_id' => $partido_id,
                'jug_id' => $jugador['jug_id'],
                // 'pju_numero_camiseta' => ,
                'pju_juvenil' => false,
                'pju_minuto_ingreso' => 0,
            );

            $validator = Validator::make($titular, PartidoJugadorTitularRequest::$rules, PartidoJugadorTitularRequest::$messages);

            if ($validator->passes()){
                $titulares[] = $titular;
            }
            else{
                foreach ($validator->errors() as $key => $value) {
                    foreach ($value as $message) {
                        $errors[] = $jugador->jug_nombre.''.$jugador->jug_apellido.': '.$value;
                    }
                }
            }
        }

        if (count($errors) > 0)
             return \Response::make($errors, 422);

        if (! $this->partidoJugador->insert($titulares))
             return \Response::make(null, 500);


        // $temp = Partido::findOrfail($partido_id)->titulares();
        // syslog(1, get_class($temp));

        return $this->obtenerJugadoresTitulares($partido_id);
    }

    public function ingresarJugadorCambio(PartidoJugadorTitularRequest $request)
    {
        $data = $request->all();
        $partidoJugadorActual = $this->partidoJugador
                                        ->find($data['pju_reemplazo_de'])
                                        ->update(['pju_minuto_salida' => $data['pju_minuto_ingreso']]);

        return $this->store($data);
    }

    private function store($atributos)
    {
        $contador = $this->partidoJugador
                            ->where('par_id', $atributos['par_id'])
                            ->where('jug_id', $atributos['jug_id'])
                            ->count();
        if($contador > 0)
            return \Response::make(null, 400);

        $partidoJugador = $this->partidoJugador->create($atributos);

        return $partidoJugador->toJson();
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $partidoJugador = $this->partidoJugador->find($id);
        
        if(!isset($partidoJugador))
            return \Response::make(null, 404);

        $partidoJugador->delete();
        return \Response::make(null, 200);
    }
}
