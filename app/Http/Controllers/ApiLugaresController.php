<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Lugar;
use App\Http\Requests\LugarRequest;

class ApiLugaresController extends Controller {

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


	/**
	 * Buscar un lugar, retorna JSON
	 * @param  string  $busqueda tipo de busqueda a realizar
	 * @param  Request $request  palabra que se va a Buscar
	 * @return json            	Los datos se devuelven en JSON
	 */
	public function consulta($busqueda, Request $request)
	{
		$keyword = $request->get('nombre');
		$tipos = $busqueda == 'all' ? ['pais','continente','ciudad'] : [$busqueda];

		if (trim(urldecode($keyword)) != '') {
			$resultados = Lugar::whereIn('lug_tipo', $tipos)
									->where('lug_nombre', 'LIKE', $keyword.'%')
									->orderBy('lug_nombre')
									->take(3)
									->get(['lug_id', 'lug_nombre', 'lug_tipo']);	
		}

		return response()->json(['data' => $resultados]);

	}

}
