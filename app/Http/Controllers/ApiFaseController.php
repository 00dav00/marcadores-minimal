<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fase;
use App\Fecha;
use Carbon\Carbon;

use App\Http\Requests\FaseRequest;

class ApiFaseController extends Controller {

	public function index()
	{
		//
	}

	public function store(FaseRequest $request)
	{
		$fase = new Fase;
		$fase->fas_descripcion = $request['fas_descripcion'];
		$fase->tfa_id = $request['tfa_id'];
		$fase->tor_id = $request['tor_id'];
		$fase->fas_acumulada = $request['fas_acumulada'];

		$fase->save();

		if($request['num_fechas'] > 0)
		{
			for($i = 0;$i < $request['num_fechas']; $i++)
			{
				Fecha::create(array('fec_numero' => $i + 1, 'fas_id' => $fase->fas_id));
			}
		}

		return $fase->toJson();
	}

	public function show($id)
	{
		$fase = Fase::findOrFail($id)
					->with('tipoFase', 'torneo')
					->where('fas_id',$id)
					->first();
					// ->get();

		return $fase->toJson();
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		$fase = Fase::findOrFail($id);

		if ($fase) {
			$fase->delete();
			return \Response::make(null, 200);
		}

		return \Response::make(null, 500);
	}

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json([], 200);
		}


		$resultados = Fase::where('fas_descripcion', 'LIKE', '%' . $keyword . '%')
							->orderBy('fas_descripcion')
							->take(3)
							->get(['fas_id', 'fas_descripcion']);


		return response()->json([$resultados]);

	}

	public function fechasRegistradas($id_fase)
	{
		$fase = Fase::findOrFail($id_fase);
		return $fase->fechas->toJson();
	}
}