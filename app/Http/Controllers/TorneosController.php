<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Torneo;

use App\Http\Requests\TorneoRequest;

class TorneosController extends Controller {

	protected $_torneos;

	public function __construct(Torneo $torneos)
	{
		$this->_torneos = $torneos;
	}

	public function index(Request $request)
	{
		$keyword = $request->get('keyword');
		$column = $request->get('column');

		$joins = ['tipoTorneo', 'equiposParticipantes'];
		
		$torneos = $this->_torneos->search($keyword, $column, $joins);
		$searchFields = [
			'tor_nombre' => 'Nombre',
			'tor_anio_referencia' => 'Año de referencia',
			'tor_fecha_inicio' => 'Fecha de inicio',
			'tor_fecha_fin' => 'Fecha de fin',
			'tor_tipo_equipos' => 'Tipo de equipos',
			'tor_numero_equipos' => 'Número de equipos',
		];

		if (!empty($keyword)) {
			flash()->info("Resultados de la búsqueda: $keyword");
		}

		return view('torneos.index', compact('torneos', 'keyword', 'column', 'searchFields'));
	}

	public function create()
	{
		return view('torneos.create');
	}

	public function store(TorneoRequest $request)
	{
		$this->_torneos->create($request->all());
		flash()->success('Torneo creado exitosamente');
		return redirect('torneos');
	}

	public function show($id)
	{
		$torneo = $this->_torneos->findOrFail($id);
		return view('torneos.show', compact('torneo'));
	}

	public function edit($id)
	{
		$torneo = $this->_torneos->findOrFail($id);
		return view('torneos.edit', compact('torneo'));
	}

	public function update($id, TorneoRequest $request)
	{
		openlog('myapplication', LOG_NDELAY, LOG_USER);
 		syslog(LOG_NOTICE, "Something has happened");
		$torneo = $this->_torneos->findOrFail($id);
		$torneo->update($request->all());
		flash()->success('Torneo editado correctamente');
		return redirect('torneos');
	}

	public function destroy($id)
	{
		$torneo = $this->_torneos->findOrFail($id);

		if ($torneo) {
			$torneo->delete();
			flash()->warning('Torneo borrado exitosamente');
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
