<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TipoFase;

use App\Http\Requests\TipoFaseRequest;

class ApiTipoFaseController extends Controller {

	public function index()
	{
		$tipo_fase = TipoFase::all();//->orderBy('tfa_nombre');
		return $tipo_fase->toJson();
	}


	public function store()
	{
		$id = TipoFase::create($request->all())->tfa_id;
		return TipoFase::findOrFail($id);
	}


	public function show($id)
	{
		//
	}


	public function update($id)
	{
		//
	}


	public function destroy($id)
	{
		//
	}


	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = TipoFase::where('tfa_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('tfa_nombre')
							->take(3)
							->get(['tfa_id', 'tfa_nombre']);


		return response()->json(['data' => $resultados]);

	}

}
