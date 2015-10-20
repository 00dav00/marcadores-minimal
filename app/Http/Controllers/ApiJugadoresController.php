<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Jugador;

class ApiJugadoresController extends Controller
{
    public function consulta(Request $request)
    {
        $keyword = trim(urldecode($request->get('nombre')));

        if ($keyword == '') 
            return \Response::json([], 200);

        $resultados = Jugador::where('jug_nombre', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('jug_apellido', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('jug_apodo', 'LIKE', '%' . $keyword . '%')
                            ->orderBy('jug_apellido')
                            ->take(3)
                            ->get(['jug_id', 'jug_nombre', 'jug_apellido', 'jug_apodo']);

        return $resultados->toJson();    
    }
}
