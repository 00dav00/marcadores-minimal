<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PartidoJugador;
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
