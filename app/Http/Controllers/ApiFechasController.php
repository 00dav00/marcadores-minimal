<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fecha;

use App\Http\Requests\FechaRequest;

class ApiFechasController extends Controller {

	public function index()
	{
		//
	}


	public function store(FechaRequest $request)
	{
		$data = $request->all();
		$data['fec_numero'] = Fecha::where('fas_id', $data['fas_id'])->max('fec_numero') + 1;
		$id = Fecha::create($data)->fec_id;

		return Fecha::findOrFail($id);
	}


	public function show($id)
	{
		$fecha = Fecha::findOrFail($id);

		$fecha['fecha_anterior'] = Fecha::where('fas_id', $fecha->fas_id)
									->where('fec_numero',$fecha->fec_numero - 1)->first();

		$fecha['fecha_siguiente'] = Fecha::where('fas_id', $fecha->fas_id)
									->where('fec_numero',$fecha->fec_numero + 1)->first();

		return $fecha->toJson();
	}


	public function update($id, Request $request)
	{
		$fecha = Fecha::findOrFail($id);
		$fecha->update($request->all());
		return \Response::make(null, 200);
	}


	public function destroy($id)
	{
		$fecha = Fecha::findOrFail($id);

		if ($fecha) {
			$fecha->delete();

			$fechas = Fecha::where('fas_id',$fecha['fas_id'])->get();
			$i = 1;

			foreach($fechas as $auxFecha)
			{
				$auxFecha['fec_numero'] = $i;
				$auxFecha->update(array(
					'fec_id' => $auxFecha['fec_id'],
					'fec_numero' => $auxFecha['fec_numero'],
					'fas_id' => $auxFecha['fas_id'],
				));
				$i++;
			}

			return \Response::make(null, 200);
		}

		return \Response::make(null, 500);
	}

	public function showFechaActual($fase_id)
	{
		$ultima_fecha_jugada_id = Fecha::where('fas_id', $fase_id)
											->where('fec_estado','jugada')
											->max('fec_id');

		if( is_null($ultima_fecha_jugada_id) )
			$ultima_fecha_jugada_id = Fecha::where('fas_id', $fase_id)->min('fec_id');			

		return $this->show($ultima_fecha_jugada_id);
	}

	public function fechaPartidosRegistrados($id)
	{
		$fecha = Fecha::findOrFail($id);
		return $fecha->partidos->toJson();
	}

}
