<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Jugador;

use App\Http\Requests\JugadorRequest;

use Image;

use File;

class JugadoresController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$jugadores = Jugador::with('nacionalidad')
					->orderBy('jug_apellido')
					->paginate(20);

		return view('jugadores.index', compact('jugadores'));
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

		$filename = $this->obtenerImagen($request);

		$data['jug_foto'] = 'images/jugadores/' . $filename;

		Jugador::create($data);

		return redirect('jugadores')->with('message', 'Jugador creado exitosamente');

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
			$filename = $this->obtenerImagen($request);
			$data['jug_foto'] = 'images/jugadores/' . $filename;
		}

		$jugador->update($data);

		return redirect('jugadores')->with('message', 'Jugador editado exitosamente');
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
			return redirect('jugadores')->with('message', 'Jugador borrado exitosamente');
		}

		return redirect('jugadores')->with('message', 'Jugador no encontrado');
	}

	/**
	 * Obtener datos y guardar una imagen que se quiere subir
	 * @param  object $request Objeto con los datos enviados por el formulario
	 * @return string          nombre del archivo con la fotografia
	 */
	protected function obtenerImagen($request)
	{
		$image = $request->file('jug_foto');
		$filename = date('Y-m-d-H:i:s'). "-" .$image->getClientOriginalName();
		$path = public_path('images/jugadores/' . $filename);
		Image::make($image->getRealPath())->resize(300, 200)->save($path);
		return $filename;
	}

}
