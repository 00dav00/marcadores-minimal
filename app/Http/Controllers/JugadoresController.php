<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Jugador;

use App\Http\Requests\JugadorRequest;

// use Image;

use File;

use App\Libraries\ImageTrait;

class JugadoresController extends Controller {

	use ImageTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{

		$keyword = $request->get('keyword');
		$column = $request->get('column');
		
		$jugadores = Jugador::search($keyword, $column);
		$searchFields = Jugador::getSearchFields();

		if (!empty($keyword)) {
			flash()->info("Resultados de la búsqueda: $keyword");
		}

		return view('jugadores.index', compact('jugadores', 'keyword', 'column', 'searchFields'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('jugadores.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(JugadorRequest $request)
	{
		$data = $request->all();

		$data['jug_foto'] = $this->procesarImagen(
									$request->file('jug_foto'),
									Jugador::getImagePath()
								);

		Jugador::create($data);

		flash()->success('Jugador creado exitosamente');

		return redirect('jugadores');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$jugador = Jugador::findOrFail($id);

		return view('jugadores.show', compact("jugador"));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$jugador = Jugador::findOrFail($id);

		return view('jugadores.edit', compact('jugador'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, JugadorRequest $request)
	{
		$jugador = Jugador::findOrFail($id);

		$data = $request->all();

		if ($request->file('jug_foto')) {
			File::delete(public_path($jugador->jug_foto));
			$data['jug_foto'] = $this->procesarImagen(
									$request->file('jug_foto'),
									Jugador::getImagePath()
								);
		}

		$jugador->update($data);

		flash()->success('Jugador actualizado exitosamente');

		return redirect('jugadores');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$jugador = Jugador::findOrFail($id);

		if ($jugador) {
			File::delete(public_path($jugador->jug_foto));
			$jugador->delete();

			flash()->warning('Jugador borrado exitosamente');

			return redirect('jugadores');
		}

		return redirect('jugadores')->with('message', 'Jugador no encontrado');
	}

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = Jugador::where('jug_nombre', 'LIKE', '%' . $keyword . '%')
							->orWhere('jug_apellido', 'LIKE', '%' . $keyword . '%')
							->orWhere('jug_apodo', 'LIKE', '%' . $keyword . '%')
							->orderBy('jug_apellido')
							->take(3)
							->get(['jug_id', 'jug_nombre', 'jug_apellido', 'jug_apodo']);


		return response()->json(['data' => $resultados]);

	}

}
