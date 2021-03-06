<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\EquipoParticipante;

use App\Http\Requests\EquipoParticipanteRequest;

class EquiposParticipantesController extends Controller {


	public function index()
	{
		$equipos = EquipoParticipante::with('torneo', 'equipo')
					->orderBy('eqp_id')
					->paginate(20);

		return view('equipos_participantes.index', compact('equipos'));
	}


	public function create()
	{
		return view('equipos_participantes.create');
	}


	public function store(EquipoParticipanteRequest $request)
	{
		EquipoParticipante::create($request->all());
		flash()->success('Equipo participante creado exitosamente');
		return redirect('equipos_participantes');
	}


	public function show($id)
	{
		$equipo = EquipoParticipante::findOrFail($id);
		return view('equipos_participantes.show', compact('equipo'));
	}


	public function edit($id)
	{
		$equipo = EquipoParticipante::findOrFail($id);

		return view('equipos_participantes.edit', compact('equipo'));
	}


	public function update($id, EquipoParticipanteRequest $request)
	{
		$equipo = EquipoParticipante::findOrFail($id);
		$equipo->update($request->all());
		flash()->success('Equipo participante actualizado exitosamente');
		return redirect('equipos_participantes');
	}


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

	// public function apiStore(EquipoParticipanteRequest $request)
	// {
	// 	EquipoParticipante::create($request->all());
	// 	return response()->json(['data' => 'Equipo inscrito exitosamente']);		
	// }

	// public function apiDestroy($torneo_id, $equipo_id)
	// {
	// 	$equipoParticipante = EquipoParticipante::where('tor_id', $torneo_id)
 //                    								->where('eqp_id', $equipo_id)
 //                    								->firstOrFail();
	// 	if ($equipoParticipante) {
	// 		$equipoParticipante->delete();
	// 	}

	// 	return response()->json(['data' => 'Equipo participante eliminado exitosamente']);
	// }
}
