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
		
		return redirect('plantillas')->with('message', 'Plantilla creada exitosamente');
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

		return redirect('plantillas')->with('message', 'Jugador actualizado correctamente');
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
			return redirect('plantillas')->with('message', 'Plantilla borrada exitosamente');
		}

		return redirect('plantillas')->with('message', 'Plantilla no encontrado');
	}

}
