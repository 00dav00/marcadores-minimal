<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EquipoRequest extends Request {

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
			'eqp_nombre' => 'required|string|min:3',
			'eqp_fecha_fundacion' => 'date_format:Y-m-d',
			'eqp_sitioweb' => 'url',
			'eqp_tipo' => 'required|in:seleccion,profesional,amateur',
			'lug_id' => 'required|integer'
		];
	}

}
