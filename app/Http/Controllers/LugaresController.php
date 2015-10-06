<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lugar;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\LugarRequest;

use Flash;

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
		
		$lugares = $this->_lugares->search($keyword, $column);
		$searchFields = $this->_lugares->getSearchFields();

		if (!empty($keyword)) 
			flash()->info("Resultados de la búsqueda: $keyword");

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

	public function update(LugarRequest $request, $id)
	{
		$lugar = $this->_lugares->findOrFail($id);

		$values = $request->all();
		if ($request['parent_lug_id'] == '') {
			$values['parent_lug_id'] = null;
		}

		$lugar->update($values);

		Flash::success('Lugar actualizado exitosamente');

		return redirect('lugares');

	}

	public function destroy($id)
	{
		//
	}

}
