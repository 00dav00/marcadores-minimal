<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Partido;
use App\Fecha;
use App\Http\Requests\PartidoRequest;

use Carbon\Carbon;

class PartidoController extends Controller {


	public function index($fecha_id)
	{
		$partidos = Partido::where('fec_id',$fecha_id)
								->with('equipoLocal','equipoVisitante','estadio')
								->paginate(3);

		$fecha = Fecha::findOrFail($fecha_id)
							->with('fase.torneo.equiposParticipantes','fase.tipoFase')
							->where('fec_id',$fecha_id)
							->first();

		// return view('partidos.index',compact('partidos'))->with('fecha', $fecha);
		return view('partidos.index',compact('partidos','fecha'));
	}


	public function create($fecha_id)
	{
		$fecha = Fecha::findOrFail($fecha_id)
							->with('fase.torneo.equiposParticipantes','fase.tipoFase')
							->where('fec_id',$fecha_id)
							->first();
		return view('partidos.create',compact('fecha'));
	}


	public function store($fecha_id, PartidoRequest $request)
	{
		$partido = $request->all();
		$partido['fec_id'] = $fecha_id;

		Partido::create($partido);
		flash()->success('Partido creado exitosamente');

		return redirect('fechas/'.$fecha_id.'/partidos');
	}


	public function show($fecha_id, $partido_id)
	{
		$partido = Partido::findOrFail($partido_id)
							->with(
								'fecha.fase.torneo'
								,'fecha.fase.tipoFase'
								,'equipoLocal'
								,'equipoVisitante'
								,'estadio'
							)
							->where('par_id',$partido_id)
							->first();


		return view('partidos.show',compact('partido'));
	}


	public function edit($fecha_id, $partido_id)
	{
		$partido = Partido::findOrFail($partido_id)
							->with(
								'fecha.fase.torneo.equiposParticipantes'
								,'fecha.fase.tipoFase'
								,'equipoLocal'
								,'equipoVisitante'
								,'estadio'
								)
							->where('par_id',$partido_id)
							->first();

		return view('partidos.edit',compact('partido'));
	}


	public function update($fecha_id, $partido_id, PartidoRequest $request)
	{
		$partido = Partido::findOrFail($partido_id);
		$partido->update($request->all());

		flash()->success('Partido actualizado exitosamente');

		return redirect('fechas/'.$fecha_id.'/partidos');
	}


	public function destroy($fecha_id, $partido_id)
	{
		$message = 'Partido no encontrado';
		$partido = Partido::findOrFail($partido_id);

		if ($partido) {
			$partido->delete();
			$message = 'Partido borrado exitosamente';
		}

		flash()->success($message);

		return redirect('fechas/'.$fecha_id.'/partidos');
	}


	// public function apiStore(PartidoRequest $request)
	// {
	// 	$partido = $request->all();

	// 	$fecha = Carbon::parse($request->input('par_fecha'));
	// 	$fecha->setTimezone('America/Bogota');
	// 	$hora = Carbon::parse($request->input('par_hora'));
	// 	$hora->setTimezone('America/Bogota');

	// 	$partido['par_fecha'] = $fecha->toDateString();
	// 	$partido['par_hora'] = $hora->toTimeString();

	// 	Partido::create($partido);

	// 	return response()->json(['data' => 'Partido creado exitosamente']);
	// }

	// public function apiShowPartidosFecha($fecha)
	// {
	// 	$partidos = Partido::with('equipoLocal',
	// 							'equipoVisitante',
	// 							'estadio')
	// 						->where('fec_id',$fecha)
	// 						->orderBy('par_goles_local','desc')
	// 						->get();
	// 	//return response()->json($partidos);
	// 	return $partidos->toJson();
	// }

	// public function apiDestroy($partido_id)
	// {
	// 	$partido = Partido::findOrFail($partido_id);

	// 	if ($partido) {
	// 		$partido->delete();
	// 	}

	// 	return response()->json(['data' => 'Partido borrado exitosamente']);
	// }

	// public function apiUpdate($partido_id, PartidoRequest $request)
	// {
	// 	$partido = Partido::findOrFail($partido_id);

	// 	$nuevosDatos = $request->all();

	// 	if ($request->input('par_fecha') && $request->input('par_fecha')) {
	// 		$fecha = Carbon::parse($request->input('par_fecha'));
	// 		$fecha->setTimezone('America/Bogota');
	// 		$hora = Carbon::parse($request->input('par_hora'));
	// 		$hora->setTimezone('America/Bogota');

	// 		$nuevosDatos['par_fecha'] = $fecha->toDateString();
	// 		$nuevosDatos['par_hora'] = $hora->toTimeString();
	// 	}
		
	// 	$partido->update($nuevosDatos);

	// 	return response()->json($request->input('par_fecha'));
	// }

	// public function apiIndex($fecha_id)
	// {
	// 	$partidos = Partido::where('fec_id',$fecha_id)->with('equipoLocal','equipoVisitante','estadio')->get();

	// 	return $partidos->toJson();
	// 	// return \Response::json($partidos);
	// }

}
