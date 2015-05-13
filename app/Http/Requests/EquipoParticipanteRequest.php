<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EquipoParticipanteRequest extends Request {

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
			'eqp_id' => 'required|integer',
			'tor_id' => 'required|integer',
		];
	}

	public function messages()
	{
		return [
	    	'eqp_id.required' => 'Es obligatorio indicar el equipo.',
	    	'eqp_id.integer' => 'La clave del equipo no es del tipo adecuado.',
	    	'tor_id.required' => 'Es obligatorio indicar el torneo.',
	    	'tor_id.integer' => 'La clave del torneo no es del tipo adecuado.',
		];
	} 
	
}
