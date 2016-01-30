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

	protected $_equipos;

	public function __construct(Equipo $equipos)
	{
		$this->_equipos = $equipos;
	}

	public function index(Request $request)
	{

		$keyword = $request->get('keyword');
		$column = $request->get('column');

		$joins = ['nacionalidad'];
		
		$equipos = $this->_equipos->search($keyword, $column, $joins);
		$searchFields = [
			'eqp_nombre' => 'Nombre', 
			'eqp_fecha_fundacion' => 'Fecha de fundación', 
			'eqp_tipo' => 'Tipo'
		];

		if (!empty($keyword)) {
			flash()->info("Resultados de la búsqueda: $keyword");
		}

		return view('equipos.index', compact('equipos', 'keyword', 'column', 'searchFields'));

	}

	public function create()
	{
		return view('equipos.create');
	}

	public function store(EquipoRequest $request)
	{
		$data = $request->all();
		$this->_setImageSize(200, 200);

		$data['eqp_escudo'] = $this->procesarImagen(
										$request->file('eqp_escudo'),
										$this->_equipos->getImagePath()
									);

		$this->_equipos->create($data);
		flash()->success('Equipo creado exitosamente');
		return redirect('equipos');
	}


	public function show($id)
	{
		$equipo = $this->_equipos->findOrFail($id);
		return view('equipos.show', compact('equipo'));
	}


	public function edit($id)
	{
		$equipo = $this->_equipos->findOrFail($id);
		return view('equipos.edit', compact('equipo'));
	}

	public function update($id, Request $request)
	{
		$equipo = $this->_equipos->findOrFail($id);
		$data = $request->all();
		$this->_setImageSize(200, 200);

		if ($request->file('eqp_escudo')) {
			File::delete(public_path($equipo->eqp_escudo));
			$data['eqp_escudo'] = $this->procesarImagen(
											$request->file('eqp_escudo'),
											$this->_equipos->getImagePath()
										);
		}

		$equipo->update($data);
		flash()->success('Equipo editado exitosamente');
		return redirect('equipos');
	}

	public function destroy($id)
	{
		$equipo = $this->_equipos->findOrFail($id);

		if ($equipo) {
			$equipo->delete();
			flash()->success('Equipo borrado exitosamente');
			return redirect('equipos');
		}

		return redirect('equipos')->with('message', 'Equipo no encontrado');
	}

}
