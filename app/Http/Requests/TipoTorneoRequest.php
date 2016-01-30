<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoTorneoRequest extends Request {


	public static $rules = array(
		'ttr_nombre' => 'required|string|min:3',
		'ttr_descripcion' => 'string|min:3'
	);

	public static $messages = array(
		'ttr_nombre.required' => 'Es obligatorio indicar el nombre del tipo de torneo.',
		'ttr_nombre.string' => 'El nombre del tipo de torneo no es válido.',
		'ttr_nombre.min' => 'El nombre del tipo de torneo debe tener como mínimo :min caracteres.',
		'ttr_descripcion.string' => 'La descripción del tipo de torneo no es válido.',
		'ttr_descripcion.min' => 'La descripción del tipo de torneo debe tener como mínimo :min caracteres.',
	);

	/*
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
		return TipoTorneoRequest::$rules;
	}

	public function messages()
	{
		return TipoTorneoRequest::$messages;
	}
}
