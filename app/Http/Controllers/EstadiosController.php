<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Estadio;

use App\Http\Requests\EstadioRequest;

use Image;

use File;

class EstadiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$keyword = $request->get('keyword');

		$column = $request->get('column');
		
		$estadios = Estadio::search($keyword, $column);

		$searchFields = Estadio::getSearchFields();

		if (!empty($keyword)) {
			flash()->info("Resultados de la búsqueda: $keyword");
		}

		return view('estadios.index', compact('estadios', 'keyword', 'column', 'searchFields'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('estadios.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EstadioRequest $request)
	{
		$data = $request->all();

		if ($request->file('est_foto_por_defecto')) 
		{
			$filename = $this->obtenerImagen($request);
			$data['est_foto_por_defecto'] = 'images/estadios/' . $filename;
		}

		Estadio::create($data);
		flash()->success('Estadio creado exitosamente');
		return redirect('estadios');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$estadio = Estadio::findOrFail($id);
		return view('estadios.show',compact('estadio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$estadio = Estadio::findOrFail($id);
		return view('estadios.edit',compact('estadio'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, EstadioRequest $request)
	{
		$estadio = Estadio::findOrFail($id);

		$data = $request->all();

		if ($request->file('est_foto_por_defecto')) {
			File::delete(public_path($estadio->est_foto_por_defecto));
			$filename = $this->obtenerImagen($request);
			$data['est_foto_por_defecto'] = 'images/estadios/' . $filename;
		}

		$estadio->update($data);
		flash()->success('Estadio actualizado exitosamente');
		return redirect('estadios');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$message = "Estadio no encontrado!";
		$estadio = Estadio::findOrFail($id);

		if ($estadio){
			File::delete(public_path($estadio->est_foto_por_defecto));
			$estadio->delete();
			$message = "Estadio borrado exitosamente!";
		}

		flash()->success($message);
		return redirect('estadios');
	}

	protected function obtenerImagen($request)
	{
		$image = $request->file('est_foto_por_defecto');
		$filename = date('Y-m-d-H:i:s'). "-" .$image->getClientOriginalName();
		$path = public_path('images/estadios/' . $filename);
		Image::make($image->getRealPath())->resize(300, 200)->save($path);
		return $filename;
	}

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json(['data' => []], 200);
		}


		$resultados = Estadio::where('est_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('est_nombre')
							->take(3)
							->get(['est_id', 'est_nombre']);


		return response()->json(['data' => $resultados]);

	}	
}
