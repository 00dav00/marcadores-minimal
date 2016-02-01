<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Equipo;

use App\Http\Requests\EquipoRequest;

class ApiEquiposController extends Controller {

	public function index()
	{
		$equipos = Equipo::all();
		return $equipos->toJson();
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
			return response()->json([], 200);
		}


		$resultados = Equipo::where('eqp_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('eqp_nombre')
							->take(3)
							->get(['eqp_id', 'eqp_nombre']);


		return response()->json([$resultados]);

	}
	
}
