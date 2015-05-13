<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TipoFase;

use App\Http\Requests\TipoFaseRequest;

class TipoFaseController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipo_fase = TipoFase::orderBy('tfa_nombre')
							->paginate(20);

		return view ('tipo_fase.index', compact('tipo_fase'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipo_fase.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TipoFaseRequest $request)
	{
		TipoFase::create($request->all());

		flash()->success('Tipo de fase creada exitosamente');
		
		return redirect('tipo_fase');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		return view('tipo_fase.show', compact('tipo_fase'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		return view('tipo_fase.edit', compact('tipo_fase'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, TipoFaseRequest $request)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		$tipo_fase->update($request->all());

		flash()->success('Tipo de fase actualizada correctamente');

		return redirect('tipo_fase');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$tipo_fase = TipoFase::findOrFail($id);

		if ($tipo_fase) {
			$tipo_fase->delete();

			flash()->warning('Tipo de fase borrada correctamente');

			return redirect('tipo_fase');
		}

		return redirect('tipo_fase')->with('message', 'Tipo de tipo_fase no encontrado');
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
