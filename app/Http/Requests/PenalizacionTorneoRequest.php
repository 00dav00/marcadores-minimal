<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PenalizacionTorneoRequest extends Request {

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
			'ptr_puntos' => 'required|integer',
			'ptr_motivo' => 'string|min:3'
			];
	}

	public function messages()
	{
		return [
			'eqp_id.required' => 'Es obligatorio indicar el equipo.',
	    	'eqp_id.integer' => 'La clave del equipo no es del tipo adecuado.',
	    	'tor_id.required' => 'Es obligatorio indicar el torneo.',
	    	'tor_id.integer' => 'La clave del torneo no es del tipo adecuado.',
	    	'ptr_puntos.required' => 'Es obligatorio indicar la cantidad de puntos.',
	    	'ptr_puntos.integer' => 'Los puntos especificados no son del tipo adecuado.',
	    	'ptr_motivo.string' => 'El motivo no es del tipo adecuado.',
	    	'ptr_motivo.min' => 'El motivo no tiene la longitud minima de 3.',
		];
	}

}
