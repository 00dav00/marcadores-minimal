<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fecha;

use App\Http\Requests\FechaRequest;

class FechasController extends Controller {

	public function index()
	{
		$fechas = Fecha::with('fase')
					->paginate(20);

		return view('fechas.index', compact('fechas'));
	}

	public function create()
	{
		return view('fechas.create');
	}

	public function store(FechaRequest $request)
	{
		Fecha::create($request->all());
		flash()->success('Fecha creada exitosamente');
		return redirect('fechas');
	}

	public function show($id)
	{
		$fecha = Fecha::findOrFail($id);
		return view('fechas.show', compact('fecha'));
	}

	public function edit($id)
	{
		$fecha = Fecha::findOrFail($id);
		return view('fechas.edit', compact('fecha'));
	}

	public function update($id, FechaRequest $request)
	{
		$fecha = Fecha::findOrFail($id);
		$fecha->update($request->all());
		flash()->success('Fecha actualizada exitosamente');

		return redirect('fechas');
	}

	public function destroy($id)
	{
		$fecha = Fecha::findOrFail($id);

		if ($fecha) {
			$fecha->delete();
			flash()->warning('Fecha borrada exitosamente');
			return redirect('fechas');
		}

		return redirect('fechas')->with('message', 'Fecha no encontrada');
	}

	public function listado()
	{
		return view('fechas.list');
	}


	public function preview($fecha_id)
	{
		$fase_id = -1;
		return view('fechas.preview', compact('fecha_id','fase_id'));
	}

	public function previewFechaActual($fase_id)
	{
		$fecha_id = -1;
		return view('fechas.preview', compact('fecha_id','fase_id'));
	}

	public function widget($fecha_id)
	{
		$fase_id = -1;
		return view('fechas.widget', compact('fecha_id','fase_id'));
	}

	public function widgetFechaActual($fase_id)
	{
		$fecha_id = -1;
		return view('fechas.widget', compact('fecha_id','fase_id'));
	}

	// public function apiShow($id)
	// {
	// 	$fecha = Fecha::findOrFail($id);

	// 	$fecha['fecha_anterior'] = Fecha::where('fas_id', $fecha->fas_id)
	// 								->where('fec_numero',$fecha->fec_numero - 1)->first();

	// 	$fecha['fecha_siguiente'] = Fecha::where('fas_id', $fecha->fas_id)
	// 								->where('fec_numero',$fecha->fec_numero + 1)->first();

	// 	return $fecha->toJson();
	// }

	// public function apiShowFechaActual($fase_id)
	// {
	// 	$ultima_fecha_jugada_id = Fecha::where('fas_id', $fase_id)
	// 										->where('fec_estado','jugada')
	// 										->max('fec_id');

	// 	if( is_null($ultima_fecha_jugada_id) )
	// 		$ultima_fecha_jugada_id = Fecha::where('fas_id', $fase_id)->min('fec_id');			

	// 	return $this->apiShow($ultima_fecha_jugada_id);
	// }

	// public function apiStore(FechaRequest $request)
	// {
	// 	$data = $request->all();
	// 	$data['fec_numero'] = Fecha::where('fas_id', $data['fas_id'])->max('fec_numero') + 1;

	// 	Fecha::create($data);

	// 	return response()->json(['data' => 'Fecha creada exitosamente', 'entidad' => $data]);
	// }

	// public function apiUpdate($id, FechaRequest $request)
	// {
	// 	$fecha = Fecha::findOrFail($id);

	// 	$fecha->update($request->all());

	// 	return response()->json(['data' => 'Fecha actualizada exitosamente']);
	// }

	// public function apiDestroy($id)
	// {
	// 	$mensaje = 'Fecha no encontrada';
	// 	$fecha = Fecha::findOrFail($id);

	// 	if ($fecha) {
	// 		$fecha->delete();

	// 		$fechas = Fecha::where('fas_id',$fecha['fas_id'])->get();
	// 		$i = 1;

	// 		foreach($fechas as $auxFecha)
	// 		{
	// 			$auxFecha['fec_numero'] = $i;
	// 			$auxFecha->update(array(
	// 				'fec_id' => $auxFecha['fec_id'],
	// 				'fec_numero' => $auxFecha['fec_numero'],
	// 				'fas_id' => $auxFecha['fas_id'],
	// 			));
	// 			$i++;
	// 		}

	// 		$mensaje = 'Fecha borrada exitosamente';
	// 	}

	// 	return response()->json(['data' => $mensaje]);
	// }

	// public function apiFechaPartidos($id)
	// {
	// 	$fecha = Fecha::findOrFail($id);
	// 	return $fecha->partidos->toJson();
	// }
}
