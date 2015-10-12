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

		$joins = ['lugarPadre'];
		
		$lugares = $this->_lugares->search($keyword, $column, $joins);
		$searchFields = ['lug_abreviatura' => 'Abreviatura', 'lug_nombre' => 'Nombre'];

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
		
		$this->_lugares->create($lugar);

		flash()->success('Lugar creado exitosamente');
		
		return redirect('lugares');
	}


	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$lugar = $this->_lugares->findOrFail($id);
		return view('lugares.edit', compact('lugar'));
	}

	public function update($id, LugarRequest $request)
	{
		$lugar = $this->_lugares->findOrFail($id);

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

}
