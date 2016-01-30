<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\EquipoParticipante;

use App\Http\Requests\EquipoParticipanteRequest;

class ApiEquiposParticipantesController extends Controller {

	public function index()
	{
		//
	}


	public function store(EquipoParticipanteRequest $request)
	{
		$equipoParticipante = new EquipoParticipante;
		$equipoParticipante->eqp_id = $request['eqp_id'];
		$equipoParticipante->tor_id = $request['tor_id'];
		$equipoParticipante->save();

		return $equipoParticipante->toJson();
	}


	public function show($id)
	{
		//
	}


	public function update($id)
	{
		//
	}


	public function destroy($torneo_id, $equipo_id)
	{
		$equipoParticipante = EquipoParticipante::where('tor_id', $torneo_id)
                    								->where('eqp_id', $equipo_id)
                    								->firstOrFail();
		if ($equipoParticipante) {
			$equipoParticipante->delete();
			return \Response::make(null, 200);
			// return true;
		}

		return \Response::make(null, 500);
		// return false;
	}

}
