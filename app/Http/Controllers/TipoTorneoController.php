<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TipoTorneo;

use App\Http\Requests\TipoTorneoRequest;

class TipoTorneoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipo_torneo = TipoTorneo::orderBy('ttr_nombre')
							->paginate(20);

		return view ('tipo_torneo.index', compact('tipo_torneo'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipo_torneo.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TipoTorneoRequest $request)
	{
		TipoTorneo::create($request->all());
		
		return redirect('tipo_torneo')->with('message', 'Tipo de torneo creado exitosamente');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$torneo = TipoTorneo::findOrFail($id);
		return view('tipo_torneo.show', compact('torneo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$torneo = TipoTorneo::findOrFail($id);
		return view('tipo_torneo.edit', compact('torneo'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$equipo = TipoTorneo::findOrFail($id);

		$equipo->update($request->all());

		return redirect('tipo_torneo')->with('message', 'Tipo de torneo actualizado correctamente');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$torneo = TipoTorneo::findOrFail($id);

		if ($torneo) {
			$torneo->delete();
			return redirect('tipo_torneo')->with('message', 'Tipo de torneo borrado exitosamente');
		}

		return redirect('tipo_torneo')->with('message', 'Tipo de torneo no encontrado');
	}

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = TipoTorneo::where('ttr_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('ttr_nombre')
							->take(3)
							->get(['ttr_codigo', 'ttr_nombre']);


		return response()->json(['data' => $resultados]);

	}

}
