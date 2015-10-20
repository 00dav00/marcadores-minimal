<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;

use Illuminate\Http\Request;

use App\Torneo;

use App\Http\Requests\TorneoRequest;

class TorneosController extends Controller {

	protected $_torneo;

	public function __construct(Torneo $torneo)
	{
		$this->_torneo = $torneo;
	}

	public function index(Request $request)
	{
		$keyword = $request->get('keyword');
		$column = $request->get('column');

		$torneos = $this->_torneo->search($keyword, $column, ['tipoTorneo', 'equiposParticipantes']);
        $searchFields = $this->_torneo->searchFields;

		if (!empty($keyword)) {
			Flash::info("Resultados de la búsqueda: $keyword");
		}

		return view('torneos.index', compact('torneos', 'keyword', 'column', 'searchFields'));
	}

	public function create()
	{
		return view('torneos.create');
	}

	public function store(TorneoRequest $request)
	{
		$this->_torneo->create($request->all());
		Flash::success('Torneo creado exitosamente');
		return redirect('torneos');
	}

	public function show($id)
	{
		$torneo = $this->_torneo->with('tipoTorneo')->findOrFail($id);
		return view('torneos.show', compact('torneo'));
	}

	public function edit($id)
	{
		$torneo = $this->_torneo->with('tipoTorneo')->findOrFail($id);
		return view('torneos.edit', compact('torneo'));
	}

	public function update($id, TorneoRequest $request)
	{
		$torneo = $this->_torneo->findOrFail($id);
		$torneo->update($request->all());
		Flash::success('Torneo actualizado exitosamente');
		return redirect('torneos');
	}

	public function destroy($id)
	{
		$torneo = $this->_torneo->findOrFail($id);

		if ($torneo) {
			$torneo->delete();
			Flash::warning('Torneo borrado exitosamente');
			return redirect('torneos');
		}

		return redirect('torneos')->with('message', 'Torneo no encontrado');
	}

	public function wizard()
	{
		return view('torneos.wizard');
	}

	public function config()
	{
		return view('torneos.config');
	}

}
