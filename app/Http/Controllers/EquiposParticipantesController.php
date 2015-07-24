<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\EquipoParticipante;

use App\Http\Requests\EquipoParticipanteRequest;

class EquiposParticipantesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$equipos = EquipoParticipante::with('torneo', 'equipo')
					->orderBy('eqp_id')
					->paginate(20);

		return view('equipos_participantes.index', compact('equipos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('equipos_participantes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EquipoParticipanteRequest $request)
	{
		EquipoParticipante::create($request->all());

		flash()->success('Equipo participante creado exitosamente');
		
		return redirect('equipos_participantes');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$equipo = EquipoParticipante::findOrFail($id);

		return view('equipos_participantes.show', compact('equipo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$equipo = EquipoParticipante::findOrFail($id);

		return view('equipos_participantes.edit', compact('equipo'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, EquipoParticipanteRequest $request)
	{
		$equipo = EquipoParticipante::findOrFail($id);

		$equipo->update($request->all());

		flash()->success('Equipo participante actualizado exitosamente');

		return redirect('equipos_participantes');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$equipo = EquipoParticipante::findOrFail($id);

		if ($equipo) {
			$equipo->delete();

			flash()->warning('Equipo participante borrado exitosamente');

			return redirect('equipos_participantes');
		}

		return redirect('equipos_participantes')->with('message', 'equipo no encontrado');
	}

	public function apiStore(EquipoParticipanteRequest $request)
	{
		EquipoParticipante::create($request->all());

		return response()->json(['data' => 'Equipo inscrito exitosamente']);		
	}

	public function apiDestroy($torneo_id, $equipo_id)
	{
		$equipoParticipante = EquipoParticipante::where('tor_id', $torneo_id)
                    								->where('eqp_id', $equipo_id)
                    								->firstOrFail();
		if ($equipoParticipante) {
			$equipoParticipante->delete();
		}

		return response()->json(['data' => 'Equipo participante eliminado exitosamente']);
	}
}
