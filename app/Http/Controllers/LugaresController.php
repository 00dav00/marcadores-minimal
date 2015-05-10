<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lugar;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\LugarRequest;

class LugaresController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$lugares = Lugar::with('lugarPadre')
					->orderBy('lug_tipo', 'pais')
					->paginate(20);

		return view('lugares.index', compact('lugares'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('lugares.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LugarRequest $request)
	{
		$lugar = $request->all();
		if ($lugar['parent_lug_id'] == '') {
			$lugar['parent_lug_id'] = null;
		}
		
		Lugar::create($lugar);
		
		return redirect('lugares')->with('message', 'Lugar creado exitosamente');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$lugar = Lugar::findOrFail($id);
		return view('lugares.edit', compact('lugar'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, LugarRequest $request)
	{
		$lugar = Lugar::findOrFail($id);

		$values = $request->all();
		if ($values['parent_lug_id'] == '') {
			$values['parent_lug_id'] = null;
		}

		$lugar->update($values);

		return redirect('lugares')->with('message', 'Lugar actualizado exitosamente');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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
									->where('lug_nombre', 'LIKE', '%'.$keyword.'%')
									->orderBy('lug_nombre')
									->take(3)
									->get(['lug_id', 'lug_nombre', 'lug_tipo']);	
		}

		return response()->json(['data' => $resultados]);

	}





}
