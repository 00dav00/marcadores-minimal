<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Estadio;

use App\Http\Requests\EstadioRequest;

// use Image;

use File;

use App\Libraries\ImageTrait;


class EstadiosController extends Controller {

	use ImageTrait;


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


	public function create()
	{
		return view('estadios.create');
	}


	public function store(EstadioRequest $request)
	{
		$data = $request->all();

		if ($request->file('est_foto_por_defecto')) 
			$data['est_foto_por_defecto'] = $this->procesarImagen(
												$request->file('est_foto_por_defecto'),
												Estadio::getImagePath()
											);
		Estadio::create($data);
		flash()->success('Estadio creado exitosamente');
		return redirect('estadios');
	}


	public function show($id)
	{
		$estadio = Estadio::findOrFail($id);
		return view('estadios.show',compact('estadio'));
	}


	public function edit($id)
	{
		$estadio = Estadio::findOrFail($id);
		return view('estadios.edit',compact('estadio'));
	}


	public function update($id, EstadioRequest $request)
	{
		$data = $request->all();
		$estadio = Estadio::findOrFail($id);

		if ($request->file('est_foto_por_defecto')) {
			File::delete(public_path($estadio->est_foto_por_defecto));
			$data['est_foto_por_defecto'] = $this->procesarImagen(
												$request->file('est_foto_por_defecto'),
												Estadio::getImagePath()
											);
		}

		$estadio->update($data);
		flash()->success('Estadio actualizado exitosamente');
		return redirect('estadios');
	}


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


	// public function consulta(Request $request)
	// {
	// 	$keyword = $request->get('nombre');

	// 	if (trim(urldecode($keyword)) == '') {
	// 		return response()->json(['data' => []], 200);
	// 	}


	// 	$resultados = Estadio::where('est_nombre', 'LIKE', '%' . $keyword . '%')
	// 						->orderBy('est_nombre')
	// 						->take(3)
	// 						->get(['est_id', 'est_nombre']);


	// 	return response()->json(['data' => $resultados]);

	// }

	// public function apiIndex()
	// {
	// 	$estadios = Estadio::all();

	// 	return $estadios->toJson();
	// }	
}
