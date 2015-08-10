<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class FaseRequest extends Request {

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
			'tfa_id' => 'required|integer',
			'fas_descripcion' => 'required|string|min:3',
			'tor_id' => 'required|integer',
			'fas_sumatoria' => 'integer',
		];
	}

	public function messages()
	{	
		return [	
			'tfa_id.required' => 'Es obligatorio indicar el tipo de fase.',
			'tfa_id.integer' => 'La clave del tipo de fase no es del tipo adecuado.',
			'fas_descripcion.required' => 'Es obligatorio indicar la descripción de la fase.',
			'fas_descripcion.string' => 'La descripción de la fase no es válida.',
			'fas_descripcion.min' => 'La descripción de la fase debe tener como mínimo :min caracteres.',
			'tor_id.required' => 'Es obligatorio indicar el torneo de la fase.',
			'tor_id.integer	' => 'La clave del tornero no es del tipo adecuado.',
		];
	}

}
