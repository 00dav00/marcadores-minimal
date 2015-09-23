<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Torneo;

use App\Http\Requests\TorneoRequest;

class TorneosController extends Controller {


	public function index(Request $request)
	{
		$keyword = $request->get('keyword');
		$column = $request->get('column');
		
		$torneos = Torneo::search($keyword, $column);
		$searchFields = Torneo::getSearchFields();

		if (!empty($keyword)) {
			flash()->info("Resultados de la búsqueda: $keyword");
		}

		return view('torneos.index', compact('torneos', 'keyword', 'column', 'searchFields'));
	}

	public function create()
	{
		return view('torneos.create');
	}

	public function store(TorneoRequest $request)
	{
		Torneo::create($request->all());
		flash()->success('Torneo creado exitosamente');
		return redirect('torneos');
	}

	public function show($id)
	{
		$torneo = Torneo::findOrFail($id);
		return view('torneos.show', compact('torneo'));
	}

	public function edit($id)
	{
		$torneo = Torneo::findOrFail($id);
		return view('torneos.edit', compact('torneo'));
	}

	public function update($id, TorneoRequest $request)
	{
		openlog('myapplication', LOG_NDELAY, LOG_USER);
 		syslog(LOG_NOTICE, "Something has happened");
		$torneo = Torneo::findOrFail($id);
		$torneo->update($request->all());
		flash()->success('Torneo editado correctamente');
		return redirect('torneos');
	}

	public function destroy($id)
	{
		$torneo = Torneo::findOrFail($id);

		if ($torneo) {
			$torneo->delete();
			flash()->warning('Torneo borrado exitosamente');
			return redirect('torneos');
		}

		return redirect('torneos')->with('message', 'Torneo no encontrado');
	}

	// public function consulta(Request $request)
	// {
	// 	$keyword = $request->get('nombre');

	// 	if (trim(urldecode($keyword)) == '') {
	// 		return response()->json(['data' => []], 200);
	// 	}


	// 	$resultados = Torneo::where('tor_nombre', 'LIKE', '%' . $keyword . '%')
	// 						->orderBy('tor_nombre')
	// 						->take(3)
	// 						->get(['tor_id', 'tor_nombre']);


	// 	return response()->json(['data' => $resultados]);

	// }

	// public function equiposParticipantes($id)
	// {
	// 	$torneo = Torneo::findOrFail($id);
	// 	return $torneo->equiposParticipantes->toJson();
	// }

	// public function jugadoresEquipoParticipante($id_torneo, $id_equipo)
	// {
	// 	$torneo = Torneo::findOrFail($id_torneo);
	// 	return $torneo->plantillas
	// 					->where('pivot.eqp_id', intval($id_equipo))
	// 					->unique();
	// }

	// public function fasesRegistradas($id_torneo)
	// {
	// 	$torneo = Torneo::findOrFail($id_torneo);
	// 	return $torneo->fases
	// 					// ->with('tipoFase')
	// 					// ->orderBy('fas_id')
	// 					->toJson();
	// }

	public function wizard()
	{
		return view('torneos.wizard');
	}

	public function config()
	{
		return view('torneos.config');
	}

	// public function apiShow($id)
	// {
	// 	$torneo = Torneo::findOrFail($id)
	// 						->with('tipoTorneo')
	// 						->where('tor_id',$id)
	// 						->first();
	// 	return $torneo->toJson();
	// }

	// public function apiIndex()
	// {
	// 	$torneos = Torneo::all();
	// 	return $torneos->toJson();
	// }
}
