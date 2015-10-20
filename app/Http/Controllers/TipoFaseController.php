<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Flash;

use App\TipoFase;
use App\Http\Requests\TipoFaseRequest;

class TipoFaseController extends Controller 
{

	protected $_tipoFase;

	public function __construct(TipoFase $tipoFase)
	{
		$this->_tipoFase = $tipoFase;
	}

	protected $tipoFase;

	public function __construct(TipoFase $tipoFase)
    {
        $this->tipoFase = $tipoFase;
    }

	public function index()
	{
		$tipo_fase = $this->_tipoFase->paginate(20);

		return view ('tipo_fase.index', compact('tipo_fase'));
	}

	public function fastCreate()
	{
		return view('tipo_fase.fast_create');
	}

	public function create()
	{
		return view('tipo_fase.create');
	}

	public function store(TipoFaseRequest $request)
	{
		$this->_tipoFase->create($request->all());

		Flash::success('Tipo de fase creada exitosamente');
		
		return redirect('tipo_fase');
	}

	public function show($id)
	{
		$tipo_fase = $this->_tipoFase->findOrFail($id);

		return view('tipo_fase.show', compact('tipo_fase'));
	}

	public function edit($id)
	{
		$tipo_fase = $this->_tipoFase->findOrFail($id);

		return view('tipo_fase.edit', compact('tipo_fase'));
	}

	public function update($id, TipoFaseRequest $request)
	{
		$tipo_fase = $this->_tipoFase->findOrFail($id);

		$tipo_fase->update($request->all());

		Flash::success('Tipo de fase actualizada correctamente');

		return redirect('tipo_fase');
	}

	public function destroy($id)
	{
		$tipo_fase = $this->_tipoFase->findOrFail($id);

		if ($tipo_fase) {
			$tipo_fase->delete();

			Flash::warning('Tipo de fase borrada correctamente');

			return redirect('tipo_fase');
		}

		return redirect('tipo_fase')->with('message', 'Tipo de tipo_fase no encontrado');
	}
}
