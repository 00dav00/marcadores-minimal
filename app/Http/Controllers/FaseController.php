<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fase;
use App\Fecha;
use Carbon\Carbon;

use App\Http\Requests\FaseRequest;


class FaseController extends Controller {

	public function index()
	{
		$fases = Fase::with('tipoFase', 'torneo')
						->orderBy('tor_id')
						->paginate(20);

		return view ('fases.index', compact('fases'));
	}

	
	public function create()
	{
		return view('fases.create');
	}


	public function store(FaseRequest $request)
	{
		Fase::create($request->all());

		flash()->success('Fase creada exitosamente');
		
		return redirect('fases');
	}


	public function show($id)
	{
		$fase = Fase::findOrFail($id);
		return view('fases.show', compact('fase'));
	}


	public function edit($id)
	{
		$fase = Fase::findOrFail($id);
		return view('fases.edit', compact('fase'));
	}


	public function update($id, FaseRequest $request)
	{
		$fase = Fase::findOrFail($id);

		$fase->update($request->all());

		flash()->success('Fase actualizada exitosamente');

		return redirect('fases');
	}


	public function destroy($id)
	{
		$fase = Fase::findOrFail($id);

		if ($fase) {
			$fase->delete();

			flash()->warning('Fase borrada exitosamente');

			return redirect('fases');
		}

		return redirect('fases')->with('message', 'Fase no encontrada');
	}

	// public function consulta(Request $request)
	// {
	// 	$keyword = $request->get('nombre');

	// 	if (trim(urldecode($keyword)) == '') {
	// 		return response()->json(['data' => []], 200);
	// 	}


	// 	$resultados = Fase::where('fas_descripcion', 'LIKE', '%' . $keyword . '%')
	// 						->orderBy('fas_descripcion')
	// 						->take(3)
	// 						->get(['fas_id', 'fas_descripcion']);


	// 	return response()->json(['data' => $resultados]);

	// }

	// public function apiShow($id)
	// {
	// 	$fase = Fase::findOrFail($id)
	// 				->with('tipoFase', 'torneo')
	// 				->where('fas_id',$id)
	// 				->first();
	// 				// ->get();

	// 	return $fase->toJson();
	// }

	// public function apiStore(FaseRequest $request)
	// {
	// 	$data = new Fase;
	// 	$data->fas_descripcion = $request['fas_descripcion'];
	// 	$data->tfa_id = $request['tfa_id'];
	// 	$data->tor_id = $request['tor_id'];
	// 	$data->fas_acumulada = $request['fas_acumulada'];

	// 	$data->save();

	// 	if($request['num_fechas'] > 0)
	// 	{
	// 		for($i = 0;$i < $request['num_fechas']; $i++)
	// 		{
	// 			Fecha::create(array(
	// 					'fec_numero' => $i + 1,
	// 					'fas_id' => $data->fas_id,
	// 				)
	// 			);
				
	// 		}
	// 	}


	// 	// Fase::create($request->all());
	// 	return response()->json(['data' => 'Fase creada exitosamente','num' => $request['num_fechas']]);
	// }


	// public function apiDestroy($id){
	// 	$mensaje = "Fase no encontrada";

	// 	$fase = Fase::findOrFail($id);

	// 	if ($fase) {
	// 		$fase->delete();

	// 		$mensaje = 'Fase borrada exitosamente';
	// 	}

	// 	return response()->json(['data' => $mensaje]);
	// }


	// public function apiFechasRegistradas($id_fase)
	// {
	// 	$fase = Fase::findOrFail($id_fase);
	// 	return $fase->fechas->toJson();
	// }
}
