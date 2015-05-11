<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\TipoEvento;

use App\Http\Requests\TipoEventoRequest;

class TiposEventoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tiposEvento = TipoEvento::orderBy('tev_codigo', 'desc')
									->paginate(20);

		return view('tipos_evento.index',compact('tiposEvento'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipos_evento.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TipoEventoRequest $request)
	{
		TipoEvento::create($request->all());
		return redirect('tipos_evento')->with('message', 'Tipo de evento creado exitosamente');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tipoEvento = TipoEvento::findOrFail($id);
		return view('tipos_evento.show',compact('tipoEvento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipoEvento = TipoEvento::findOrFail($id);
		return view('tipos_evento.edit',compact('tipoEvento'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, TipoEventoRequest $request)
	{
		$tipoEvento = TipoEvento::findOrFail($id);
		$tipoEvento->update($request->all());
		return redirect('tipos_evento')
			->with('message','Tipo de Evento actualizado correctamente');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$tipoEvento = TipoEvento::findOrFail($id);
		$message = 'Tipo de Evento no encontrado.';
		
		if($tipoEvento)
		{
			$tipoEvento->delete();
			$message = 'Tipo de Evento borrado exitosamente.';
		}

		return redirect('tipos_evento')->with('message',$message);
	}


	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = TipoEvento::where('tev_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('tev_nombre')
							->take(3)
							->get(['tev_codigo', 'tev_nombre']);


		return response()->json(['data' => $resultados]);

	}
}
