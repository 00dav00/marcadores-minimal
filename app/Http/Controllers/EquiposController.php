<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Equipo;

use App\Http\Requests\EquipoRequest;

class EquiposController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$equipos = Equipo::with('nacionalidad')
					->orderBy('eqp_nombre')
					->paginate(20);

		return view('equipos.index', compact('equipos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('equipos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EquipoRequest $request)
	{
		
		Equipo::create($request->all());
		
		return redirect('equipos')->with('message', 'Lugar creado exitosamente');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$equipo = Equipo::findOrFail($id);

		return view('equipos.show', compact('equipo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$equipo = Equipo::findOrFail($id);

		return view('equipos.edit', compact('equipo'));
	}

	/**
	 * 
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$equipo = Equipo::findOrFail($id);

		$equipo->update($request->all());

		return redirect('equipos')->with('message', 'Equipo actualizado correctamente');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$equipo = Equipo::findOrFail($id);

		if ($equipo) {
			$equipo->delete();
			return redirect('equipos')->with('message', 'Equipo borrado exitosamente');
		}

		return redirect('equipos')->with('message', 'Equipo no encontrado');
	}

}
