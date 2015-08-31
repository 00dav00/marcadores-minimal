<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\PenalizacionTorneo;

use App\Http\Requests\PenalizacionTorneoRequest;

class ApiPenalizacionesTorneoController extends Controller {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PenalizacionTorneoRequest $request)
	{
		PenalizacionTorneo::create($request->all());

		return response()->json([
			'data' => 'Penalizacion ingresada exitosamente'
			]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($torneo)
	{
		$penalizaciones = PenalizacionTorneo::with('torneo', 'equipo', 'fase')
			->where('tor_id', '=', $torneo)
			->get();

		return response()->json([
			'data' => $penalizaciones
			]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($torneo, $fase, $equipo, PenalizacionTorneoRequest $request)
	{
		$penalizacion = PenalizacionTorneo::where('tor_id', $torneo)
                    						->where('eqp_id', $equipo)
                    						->where('fas_id', $fase)
                    						->firstOrFail();

        $penalizacion->update($request->all());

        return response()->json([
			'data' => 'Penalizacion actualizada exitosamente'
			]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($torneo, $fase, $equipo) 
	{
		$penalizacion = PenalizacionTorneo::where('tor_id', $torneo)
                    						->where('eqp_id', $equipo)
                    						->where('fas_id', $fase)
                    						->firstOrFail();

        $penalizacion->delete();

        return response()->json([
			'data' => 'Penalizacion borrada exitosamente'
			]);
	}

}
