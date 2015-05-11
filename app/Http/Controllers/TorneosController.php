<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Torneo;

use App\Http\Requests\TorneoRequest;

class TorneosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$torneos = Torneo::with('lugar', 'tipoTorneo')
					->orderBy('tor_nombre')
					->paginate(20);

		return view('torneos.index', compact('torneos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('torneos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TorneoRequest $request)
	{
		Torneo::create($request->all());

		flash()->success('Torneo creado exitosamente');
		
		return redirect('torneos');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$torneo = Torneo::findOrFail($id);

		return view('torneos.show', compact('torneo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$torneo = Torneo::findOrFail($id);

		return view('torneos.edit', compact('torneo'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, TorneoRequest $request)
	{
		$torneo = Torneo::findOrFail($id);

		$torneo->update($request->all());

		flash()->success('Torneo editado correctamente');

		return redirect('torneos');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = Torneo::where('tor_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('tor_nombre')
							->take(3)
							->get(['tor_id', 'tor_nombre']);


		return response()->json(['data' => $resultados]);

	}

	public function equiposParticipantes($id)
	{
		$torneo = Torneo::findOrFail($id);
		return $torneo->equiposParticipantes->toJson();
	}

	public function jugadoresEquipoParticipante($id_torneo, $id_equipo)
	{
		$torneo = Torneo::findOrFail($id_torneo);
		return $torneo->plantilla->where('pivot.eqp_id', intval($id_equipo))->toJson();
	}
}
