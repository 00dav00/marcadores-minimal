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
					->orderBy('fec_fecha_referencia')
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

}
