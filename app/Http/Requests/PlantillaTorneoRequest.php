<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlantillaTorneoRequest extends Request {

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
			'plt_numero_camiseta' => 'required|integer',
			'eqp_id' => 'required|integer',
			'jug_id' => 'required|integer',
			'tor_id' => 'required|integer',
		];
	}

	public function messages()
	{
		return [
			'plt_numero_camiseta.required' => 'Es obligatorio ingresar el número de camiseta.',
			'plt_numero_camiseta.integer' => 'El número de camiseta debe ser un número entero',
			'eqp_id.required' => 'Es obligatorio ingresar el equipo.',
			'eqp_id.integer' => 'La clave del equipo no es del tipo adecuado.',
			'jug_id.required' => 'Es obligatorio ingresar el jugador.',
			'jug_id.integer' => 'La clave del jugador no es del tipo adecuado.',
			'tor_id.required' => 'Es obligatorio ingresar el torneo.',
			'tor_id.integer' => 'La clave del tornero no es del tipo adecuado.',
		];
	}
}
