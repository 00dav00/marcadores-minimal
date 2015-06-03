<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\PlantillaTorneo;

use App\Http\Requests\PlantillaTorneoRequest;

class PlantillasTorneoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$plantillas = PlantillaTorneo::with('torneo', 'equipo', 'jugador')
					->orderBy('eqp_id')
					->paginate(20);

		return view('plantillas.index', compact('plantillas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('plantillas.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PlantillaTorneoRequest $request)
	{
		PlantillaTorneo::create($request->all());

		flash()->success('Plantilla creada exitosamente');
		
		return redirect('plantillas');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$plantilla = PlantillaTorneo::findOrFail($id);

		return view('plantillas.show', compact('plantilla'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$plantilla = PlantillaTorneo::findOrFail($id);

		return view('plantillas.edit', compact('plantilla'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, PlantillaTorneoRequest $request)
	{
		$plantilla = PlantillaTorneo::findOrFail($id);

		$plantilla->update($request->all());

		flash()->success('Plantilla actualizada exitosamente');

		return redirect('plantillas');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$plantilla = PlantillaTorneo::findOrFail($id);

		if ($plantilla) {
			$plantilla->delete();
			flash()->success('Plantilla borrada exitosamente');
			return redirect('plantillas');
		}

		return redirect('plantillas')->with('message', 'Plantilla no encontrado');
	}


	public function config()
	{
		return view('plantillas.config');
	}


	public function apiShow($id)
	{
		$plantilla = PlantillaTorneo::findOrFail($id)
										->with('jugador')
										->first();
		return response()->json(['data' => $plantilla]);
	}

	public function apiStore(PlantillaTorneoRequest $request)
	{
		PlantillaTorneo::create($request->all());

		return response()->json(['data' => 'Plantilla creada exitosamente']);		
	}

	public function apiUpdate($id, PlantillaTorneoRequest $request)
	{
		$plantilla = PlantillaTorneo::findOrFail($id);
		$plantilla->update($request->all());

		return response()->json(['data' => 'Jugador participante actualizado exitosamente']);
	}

	public function apiDestroy($id)
	{
		$plantilla = PlantillaTorneo::findOrFail($id);

		if ($plantilla) {
			$plantilla->delete();
		}

		return response()->json(['data' => 'Jugador participante eliminado exitosamente']);
	}

}
