<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Partido;
use App\Fecha;
use App\Http\Requests\PartidoRequest;

use Carbon\Carbon;

class ApiPartidosController extends Controller
{

    public function index($fecha_id)
    {
        $partidos = Partido::where('fec_id',$fecha_id)->with('equipoLocal','equipoVisitante','estadio')->get();
        return $partidos->toJson();
    }


    public function store(PartidoRequest $request)
    {
        $partido = $request->all();

        $fecha = Carbon::parse($request->input('par_fecha'));
        $fecha->setTimezone('America/Bogota');
        $hora = Carbon::parse($request->input('par_hora'));
        $hora->setTimezone('America/Bogota');

        $partido['par_fecha'] = $fecha->toDateString();
        $partido['par_hora'] = $hora->toTimeString();

        $id = Partido::create($partido)->par_id;

        return Partido::findOrFail($id)->toJson();
    }


    public function show($id)
    {
        //
    }


    public function update($partido_id, PartidoRequest $request)
    {
        $partido = Partido::findOrFail($partido_id);

        $nuevosDatos = $request->all();

        if ($request->input('par_fecha') && $request->input('par_fecha')) {
            $fecha = Carbon::parse($request->input('par_fecha'));
            //$fecha->setTimezone('America/Bogota');
            $hora = Carbon::parse($request->input('par_hora'));
            $hora->setTimezone('America/Bogota');

            $nuevosDatos['par_fecha'] = $fecha->toDateString();
            $nuevosDatos['par_hora'] = $hora->toTimeString();
        }
        
        $partido->update($nuevosDatos);

        return \Response::make(null, 200);
    }


    public function destroy($partido_id)
    {
        $partido = Partido::findOrFail($partido_id);

        if ($partido) {
            $partido->delete();
            return \Response::make(null, 200);
        }

        return \Response::make(null, 500);
    }

    public function showPartidosFecha($fecha)
    {
        $partidos = Partido::with('equipoLocal',
                                'equipoVisitante',
                                'estadio')
                            ->where('fec_id',$fecha)
                            ->orderBy('par_goles_local','desc')
                            ->get();
        //return response()->json($partidos);
        return $partidos->toJson();
    }
}
