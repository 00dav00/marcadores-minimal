<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Equipo;

use App\Http\Requests\EquipoRequest;

// use Image;

use File;

use App\Libraries\ImageTrait;

class EquiposController extends Controller {

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
		
		$equipos = Equipo::search($keyword, $column);

		$searchFields = Equipo::getSearchFields();

		if (!empty($keyword)) {
			flash()->info("Resultados de la búsqueda: $keyword");
		}

		return view('equipos.index', compact('equipos', 'keyword', 'column', 'searchFields'));

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
		$data = $request->all();

		$data['eqp_escudo'] = $this->procesarImagen(
										$request->file('eqp_escudo'),
										Equipo::getImagePath()
									);

		Equipo::create($data);

		flash()->success('Equipo creado exitosamente');
		
		return redirect('equipos');
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

		$data = $request->all();

		if ($request->file('eqp_escudo')) {
			File::delete(public_path($equipo->eqp_escudo));

			$data['eqp_escudo'] = $this->procesarImagen(
											$request->file('eqp_escudo'),
											Equipo::getImagePath()
										);
		}

		$equipo->update($data);

		flash()->success('Equipo editado exitosamente');

		return redirect('equipos');
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

			flash()->success('Equipo borrado exitosamente');

			return redirect('equipos');
		}

		return redirect('equipos')->with('message', 'Equipo no encontrado');
	}

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = Equipo::where('eqp_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('eqp_nombre')
							->take(3)
							->get(['eqp_id', 'eqp_nombre']);


		return response()->json(['data' => $resultados]);

	}

}
