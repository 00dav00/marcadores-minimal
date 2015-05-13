<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoFaseRequest extends Request {

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
			'tfa_nombre' => 'required|string|min:3',
			'tfa_descripcion' => 'string|min:3'
		];
	}


	public function messages()
	{
		return [
			'tfa_nombre.required' => 'Es obligatorio indicar el nombre del tipo de fase.',
			'tfa_nombre.string' => 'El nombre del tipo de fase no es válido.',
			'tfa_nombre.min' => 'El nombre del tipo de fase debe tener como mínimo :min caracteres.',
			'tfa_descripcion.string' => 'La descripción del tipo de fase no es válido.',
			'tfa_descripcion.min' => 'La descripción del tipo de fase debe tener como mínimo :min caracteres.',
		];
	}
}
