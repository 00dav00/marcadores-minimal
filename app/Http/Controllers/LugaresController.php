<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lugar;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\LugarRequest;

class LugaresController extends Controller {

	protected $_lugares;

	public function __construct(Lugar $lugares)
	{
		$this->_lugares = $lugares;
	}

	public function index(Request $request)
	{
		$keyword = $request->get('keyword');
		$column = $request->get('column');
		
		$lugares = $this->_lugares->search($keyword, $column);
		$searchFields = $this->_lugares->getSearchFields();

		if (!empty($keyword)) {
			flash()->info("Resultados de la búsqueda: $keyword");
		}

		return view('lugares.index', compact('lugares', 'keyword', 'column', 'searchFields'));
	}


	public function create()
	{
		return view('lugares.create');
	}


	public function store(LugarRequest $request)
	{
		$lugar = $request->all();
		if ($lugar['parent_lug_id'] == '') {
			$lugar['parent_lug_id'] = null;
		}
		
		Lugar::create($lugar);

		flash()->success('Lugar creado exitosamente');
		
		return redirect('lugares');
	}


	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$lugar = Lugar::findOrFail($id);
		return view('lugares.edit', compact('lugar'));
	}

	public function update($id, LugarRequest $request)
	{
		$lugar = Lugar::findOrFail($id);

		$values = $request->all();
		if ($values['parent_lug_id'] == '') {
			$values['parent_lug_id'] = null;
		}

		$lugar->update($values);

		flash()->success('Lugar editado exitosamente');

		return redirect('lugares');

	}

	public function destroy($id)
	{
		//
	}

	// /**
	//  * Buscar un lugar, retorna JSON
	//  * @param  string  $busqueda tipo de busqueda a realizar
	//  * @param  Request $request  palabra que se va a Buscar
	//  * @return json            	Los datos se devuelven en JSON
	//  */
	// public function consulta($busqueda, Request $request)
	// {
	// 	$keyword = $request->get('nombre');
	// 	$tipos = $busqueda == 'all' ? ['pais','continente','ciudad'] : [$busqueda];

	// 	if (trim(urldecode($keyword)) != '') {
	// 		$resultados = Lugar::whereIn('lug_tipo', $tipos)
	// 								->where('lug_nombre', 'LIKE', $keyword.'%')
	// 								->orderBy('lug_nombre')
	// 								->take(3)
	// 								->get(['lug_id', 'lug_nombre', 'lug_tipo']);	
	// 	}

	// 	return response()->json(['data' => $resultados]);

	// }





}
