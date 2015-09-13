<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TipoTorneo;

use App\Http\Requests\TipoTorneoRequest;

class TipoTorneoController extends Controller {

	public function index()
	{
		$tipo_torneo = TipoTorneo::orderBy('ttr_nombre')
							->paginate(20);

		return view ('tipo_torneo.index', compact('tipo_torneo'));
	}


	public function create()
	{
		return view('tipo_torneo.create');
	}


	public function store(TipoTorneoRequest $request)
	{
		TipoTorneo::create($request->all());

		flash()->success('Tipo de torneo creado exitosamente');
		
		return redirect('tipo_torneo');
	}


	public function show($id)
	{
		$torneo = TipoTorneo::findOrFail($id);
		return view('tipo_torneo.show', compact('torneo'));
	}


	public function edit($id)
	{
		$torneo = TipoTorneo::findOrFail($id);
		return view('tipo_torneo.edit', compact('torneo'));
	}


	public function update($id, TipoTorneoRequest $request)
	{
		$equipo = TipoTorneo::findOrFail($id);

		$equipo->update($request->all());

		flash()->success('Tipo de torneo actualizado correctamente');

		return redirect('tipo_torneo');
	}


	public function destroy($id)
	{
		$torneo = TipoTorneo::findOrFail($id);

		if ($torneo) {
			$torneo->delete();

			flash()->warning('Tipo de torneo borrado correctamente');

			return redirect('tipo_torneo');
		}

		return redirect('tipo_torneo')->with('message', 'Tipo de torneo no encontrado');
	}

	// public function consulta(Request $request)
	// {
	// 	$keyword = $request->get('nombre');

	// 	if (trim(urldecode($keyword)) == '') {
	// 		return response()->json(['data' => []], 200);
	// 	}


	// 	$resultados = TipoTorneo::where('ttr_nombre', 'LIKE', '%' . $keyword . '%')
	// 						->orderBy('ttr_nombre')
	// 						->take(3)
	// 						->get(['ttr_id', 'ttr_nombre']);


	// 	return response()->json(['data' => $resultados]);

	// }
}
