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

	protected $_estadios;

	public function __construct(Estadio $estadios)
	{
		$this->_estadios = $estadios;
	}

	public function index(Request $request)
	{
		$keyword = $request->get('keyword');
		$column = $request->get('column');

		$joins = ['ubicacion'];

		$estadios = $this->_estadios->search($keyword, $column, $joins);
		$searchFields = ['est_nombre' => 'Nombre', 'est_fecha_inauguracion' => 'Fecha de inauguración'];

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
												$this->_estadios->getImagePath()
											);
		$this->_estadios->create($data);
		flash()->success('Estadio creado exitosamente');
		return redirect('estadios');
	}


	public function show($id)
	{
		$estadio = $this->_estadios->findOrFail($id);
		return view('estadios.show',compact('estadio'));
	}


	public function edit($id)
	{
		$estadio = $this->_estadios->findOrFail($id);
		return view('estadios.edit',compact('estadio'));
	}


	public function update($id, EstadioRequest $request)
	{
		$data = $request->all();
		$estadio = $this->_estadios->findOrFail($id);

		if ($request->file('est_foto_por_defecto')) {
			File::delete(public_path($estadio->est_foto_por_defecto));
			$data['est_foto_por_defecto'] = $this->procesarImagen(
												$request->file('est_foto_por_defecto'),
												$this->_estadios->getImagePath()
											);
		}

		$estadio->update($data);
		flash()->success('Estadio actualizado exitosamente');
		return redirect('estadios');
	}


	public function destroy($id)
	{
		$message = "Estadio no encontrado!";
		$estadio = $this->_estadios->findOrFail($id);

		if ($estadio){
			File::delete(public_path($estadio->est_foto_por_defecto));
			$estadio->delete();
			$message = "Estadio borrado exitosamente!";
		}

		flash()->success($message);
		return redirect('estadios');
	}

}
