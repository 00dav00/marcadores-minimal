<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fase;

use App\Http\Requests\FaseRequest;


class FaseController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fases = Fase::with('tipoFase', 'torneo')
						->orderBy('tor_id')
						->paginate(20);

		return view ('fases.index', compact('fases'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('fases.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(FaseRequest $request)
	{
		Fase::create($request->all());
		
		return redirect('fases')->with('message', 'Fase creada exitosamente');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$fase = Fase::findOrFail($id);
		return view('fases.show', compact('fase'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$fase = Fase::findOrFail($id);
		return view('fases.edit', compact('fase'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, FaseRequest $request)
	{
		$fase = Fase::findOrFail($id);

		$fase->update($request->all());

		return redirect('fases')->with('message', 'Fase actualizada correctamente');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$fase = Fase::findOrFail($id);

		if ($fase) {
			$fase->delete();
			return redirect('fases')->with('message', 'Fase borrada exitosamente');
		}

		return redirect('fases')->with('message', 'Fase no encontrada');
	}

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = Fase::where('fas_descripcion', 'LIKE', '%' . $keyword . '%')
							->orderBy('fas_descripcion')
							->take(3)
							->get(['fas_id', 'fas_descripcion']);


		return response()->json(['data' => $resultados]);

	}

}
