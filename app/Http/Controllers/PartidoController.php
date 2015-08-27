<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Partido;
use App\Fecha;
use App\Http\Requests\PartidoRequest;

use Carbon\Carbon;

class PartidoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($fecha_id)
	{
		$fecha = Fecha::findOrFail($fecha_id)
							->with('fase.torneo.equiposParticipantes','fase.tipoFase')
							->where('fec_id',$fecha_id)
							->first();
		return view('partidos.create',compact('fecha'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($fecha_id, PartidoRequest $request)
	{
		$partido = $request->all();
		$partido['fec_id'] = $fecha_id;
		Partido::create($partido);

		flash()->success('Partido creado exitosamente');

		return redirect('fechas/'.$fecha_id.'/partidos');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($fecha_id, $partido_id, PartidoRequest $request)
	{
		$partido = Partido::findOrFail($partido_id);
		$partido->update($request->all());

		flash()->success('Partido actualizado exitosamente');

		return redirect('fechas/'.$fecha_id.'/partidos');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function apiStore(PartidoRequest $request)
	{
		$partido = $request->all();

		$fecha = Carbon::parse($request->input('par_fecha'));
		$fecha->setTimezone('America/Bogota');
		$hora = Carbon::parse($request->input('par_hora'));
		$hora->setTimezone('America/Bogota');

		$partido['par_fecha'] = $fecha->toDateString();
		$partido['par_hora'] = $hora->toTimeString();

		Partido::create($partido);

		return response()->json(['data' => 'Partido creado exitosamente']);
	}

	public function apiShowPartidosFecha($fecha)
	{
		$partidos = Partido::with('equipoLocal',
								'equipoVisitante',
								'estadio')
							->where('fec_id',$fecha)
							->get();
		//return response()->json($partidos);
		return $partidos->toJson();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function apiDestroy($partido_id)
	{
		$partido = Partido::findOrFail($partido_id);

		if ($partido) {
			$partido->delete();
		}

		return response()->json(['data' => 'Partido borrado exitosamente']);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function apiUpdate($partido_id, PartidoRequest $request)
	{
		$partido = Partido::findOrFail($partido_id);

		$nuevosDatos = $request->all();

		$fecha = Carbon::parse($request->input('par_fecha'));
		$fecha->setTimezone('America/Bogota');
		$hora = Carbon::parse($request->input('par_hora'));
		$hora->setTimezone('America/Bogota');

		$nuevosDatos['par_fecha'] = $fecha->toDateString();
		$nuevosDatos['par_hora'] = $hora->toTimeString();
		
		$partido->update($nuevosDatos);

		return response()->json(['data' => 'Partido borrado exitosamente']);
	}

	public function apiIndex($fecha_id)
	{
		$partidos = Partido::where('fec_id',$fecha_id)->with('equipoLocal','equipoVisitante','estadio')->get();

		return $partidos->toJson();
		// return \Response::json($partidos);
	}

}
