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
		$keyword = trim(urldecode($request->get('nombre')));
		if ($keyword == '') 
            return \Response::json([], 200);

		$terms = ['continente', 'pais', 'provincia', 'ciudad'];
		$tipos = in_array($busqueda, $terms) ? [$busqueda] : $terms;
		// return $tipos;

		$resultados = Lugar::whereIn('lug_tipo', $tipos)
									->where('lug_nombre', 'LIKE', '%'. $keyword .'%')
									->orderBy('lug_nombre')
									->take(3)
									->get(['lug_id', 'lug_nombre', 'lug_tipo']);
										
		return $resultados->toJson();	

	}

}
