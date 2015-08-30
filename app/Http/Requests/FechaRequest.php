<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class FechaRequest extends Request {

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
			'fas_id' => 'required|integer',
			'fec_numero' => 'required|integer|min:1',
			'fec_estado' => 'in:jugada,no_jugada,en_juego,suspendida',
		];
	}

	public function messages()
	{
		return [
			'fas_id.required' => 'Es obligatorio indicar la fase de la fecha.',
			'fas_id.integer' => 'La clave de la fase no es del tipo adecuado.',
			'fec_numero.required' => 'Es obligatorio indicar número de la fecha.',
			'fec_numero.integer' => 'El número de fecha debe ser un entero.',
			'fec_numero.min' => 'El número de fecha debe tener al menos 1 digito.',
		];
	}

}
