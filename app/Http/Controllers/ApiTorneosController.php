<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Torneo;
use App\Http\Requests\TorneoRequest;

class ApiTorneosController extends Controller {

	protected $torneo;

    public function __construct(Torneo $torneo)
    {
        $this->torneo = $torneo;
    }

	public function index()
	{
		$torneos = $this->torneo->all();
		return $torneos->toJson();
	}

	public function show($id)
	{
		$torneo = $this->torneo->with('tipoTorneo')->findOrFail($id);
		return $torneo->toJson();
	}

	public function consulta(Request $request)
	{
		$keyword = $request->get('nombre');

		if (trim(urldecode($keyword)) == '') {
			return response()->json([], 200);
		}


		$resultados = $this->torneo->where('tor_nombre', 'LIKE', '%' . $keyword . '%')
							->orderBy('tor_nombre')
							->take(3)
							->get(['tor_id', 'tor_nombre']);


		return $resultados->toJson();

	}

	public function equiposParticipantes($id)
	{
		$torneo = $this->torneo->findOrFail($id);
		return $torneo->equiposParticipantes->toJson();
	}	

	public function fasesRegistradas($id_torneo)
	{
		$torneo = $this->torneo->findOrFail($id_torneo);
		return $torneo->fases->toJson();
	}

	public function penalizaciones($id)
	{
		$torneo = $this->torneo->findOrFail($id);

		return $torneo->penalizaciones->toJson();
	}

	public function jugadoresEquipoParticipante($id_torneo, $id_equipo)
	{
		$torneo = Torneo::findOrFail($id_torneo);
		return $torneo->plantillas
						->where('pivot.eqp_id', intval($id_equipo))
						->unique();
	}
}
