<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\TipoTorneo;
use App\Http\Requests\TipoTorneoRequest;

class ApiTipoTorneoController extends Controller {

	public function index()
	{
		//
	}

	public function store()
	{
		//
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


		$resultados = TipoTorneo::where('ttr_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('ttr_nombre')
							->take(3)
							->get(['ttr_id', 'ttr_nombre']);


		return response()->json(['data' => $resultados]);

	}
}
