<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TorneoRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'tor_nombre' => 'required|string|min:3',
			'tor_anio_referencia' => 'required|integer',
			'tor_fecha_inicio' => 'required|date_format:Y-m-d',
			'tor_fecha_fin' => 'required|date_format:Y-m-d',
			'tor_tipo_equipos'=> 'required|in:seleccion,profesional,amateur',
			'lug_id' => 'required|integer',
			'ttr_codigo' => 'required|integer'
		];
	}

}
