<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Estadio;

use App\Http\Requests\EstadioRequest;

class ApiEstadiosController extends Controller {

	public function index()
	{
		$estadios = Estadio::all();
		return $estadios->toJson();
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

		$resultados = Estadio::where('est_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('est_nombre')
							->take(3)
							->get(['est_id', 'est_nombre']);


		return response()->json(['data' => $resultados]);

	}
}
