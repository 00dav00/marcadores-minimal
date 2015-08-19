<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fecha;

use App\Http\Requests\FechaRequest;

class FechasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fechas = Fecha::with('fase')
					->paginate(20);

		return view('fechas.index', compact('fechas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('fechas.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(FechaRequest $request)
	{
		Fecha::create($request->all());

		flash()->success('Fecha creada exitosamente');
		
		return redirect('fechas');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$fecha = Fecha::findOrFail($id);

		return view('fechas.show', compact('fecha'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$fecha = Fecha::findOrFail($id);

		return view('fechas.edit', compact('fecha'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, FechaRequest $request)
	{
		$fecha = Fecha::findOrFail($id);

		$fecha->update($request->all());

		flash()->success('Fecha actualizada exitosamente');

		return redirect('fechas');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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

	public function apiStore(FechaRequest $request)
	{
		$data = $request->all();
		$data['fec_numero'] = Fecha::where('fas_id', $data['fas_id'])->max('fec_numero') + 1;

		Fecha::create($data);

		return response()->json(['data' => 'Fecha creada exitosamente', 'entidad' => $data]);
	}

	public function apiUpdate($id, FechaRequest $request)
	{
		$fecha = Fecha::findOrFail($id);

		$fecha->update($request->all());

		return response()->json(['data' => 'Fecha actualizada exitosamente']);
	}

	public function apiDestroy($id)
	{
		$mensaje = 'Fecha no encontrada';
		$fecha = Fecha::findOrFail($id);

		if ($fecha) {
			$fecha->delete();

			$fechas = Fecha::where('fas_id',$fecha['fas_id'])->get();
			$i = 1;

			foreach($fechas as $auxFecha)
			{
				$auxFecha['fec_numero'] = $i;
				$auxFecha->update(array(
					'fec_id' => $auxFecha['fec_id'],
					'fec_numero' => $auxFecha['fec_numero'],
					'fas_id' => $auxFecha['fas_id'],
				));
				$i++;
			}

			$mensaje = 'Fecha borrada exitosamente';
		}

		return response()->json(['data' => $mensaje]);
	}

	public function apiFechaPartidos($id)
	{
		$fecha = Fecha::findOrFail($id);
		return $fecha->partidos->toJson();
	}
}
