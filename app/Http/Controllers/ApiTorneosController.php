<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\Torneo;
use App\Http\Requests\TorneoRequest;

class ApiTorneosController extends Controller {

	public function index()
	{
		$torneos = Torneo::all();
		return $torneos->toJson();
	}

	public function store(TorneoRequest $request)
	{
	   	$id = Torneo::create($request->all())->id;
		return Torneo::findOrFail($id);
	}

	public function show($id)
	{
		$torneo = Torneo::findOrFail($id)
							->with('tipoTorneo')
							->where('tor_id',$id)
							->first();
		return $torneo->toJson();
	}

	public function update($id, TorneoRequest $request)
	{
		$torneo = Torneo::findOrFail($id);
		$torneo->update($request->all());
		// return $torneo->toJson();
		return \Response::make(null, 200);
	}

	public function destroy($id)
	{
	 	$torneo = Torneo::findOrFail($id);

		if ($torneo){
			$torneo->delete();
			return \Response::make(null, 200);
		}

		return \Response::make(null, 500);
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

	public function fasesRegistradas($id_torneo)
	{
		$torneo = Torneo::findOrFail($id_torneo);
		return $torneo->fases->toJson();
	}
}
