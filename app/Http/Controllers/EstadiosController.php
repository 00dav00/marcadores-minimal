<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Estadio;

use App\Http\Requests\EstadioRequest;

use File;

use Flash;

class EstadiosController extends Controller {

	protected $_estadios;

	public function __construct(Estadio $estadios)
	{
		$this->_estadios = $estadios;
	}

	public function index(Request $request)
	{
		$keyword = $request->get('keyword');
		$column = $request->get('column');

		$estadios = $this->_estadios->search($keyword, $column, ['ubicacion']);
		$searchFields = $this->_estadios->searchFields;

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

        if ($request->file('est_foto_por_defecto')) {
			$data['est_foto_por_defecto'] = $this->_estadios
            									->procesarImagen($request->file('est_foto_por_defecto'));
        }

        $this->_estadios->create($data);
		Flash::success('Estadio creado exitosamente');
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
			$data['est_foto_por_defecto'] = $estadio->reemplazarImagen($request->file('est_foto_por_defecto'));
		}

		$estadio->update($data);
		Flash::success('Estadio actualizado exitosamente');
		return redirect('estadios');
	}


	public function destroy($id)
	{
		$message = "Estadio no encontrado!";
		$estadio = $this->_estadios->findOrFail($id);

		if ($estadio){
			$estadio->delete();
			$message = "Estadio borrado exitosamente!";
		}

		Flash::success($message);
		return redirect('estadios');
	}

}
