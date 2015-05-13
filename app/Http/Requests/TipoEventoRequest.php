<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoEventoRequest extends Request {

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
			'tev_nombre' => 'required|string|min:3|max:50',
			'tev_descripcion' => 'string|min:3|max:200', 
			'tev_comentario1' => 'string|min:3|max:100', 
			'tev_comentario2' => 'string|min:3|max:100', 
		];
	}

	public function messages()
	{
		return [
			'tev_nombre.required' => 'Es obligatorio indicar el nombre del tipo de evento.',
			'tev_nombre.string' => 'El nombre del tipo de evento no es válido.',
			'tev_nombre.min' => 'El nombre del tipo de evento debe tener como mínimo :min caracteres.',
			'tev_nombre.max' => 'El nombre del tipo de evento debe tener como máximo :max caracteres.',
			'tev_descripcion.string' => 'La descripción tipo de evento no es válida.',
			'tev_descripcion.min' => 'La descripción tipo de evento debe tener como mínimo :min caracteres.',
			'tev_descripcion.max' => 'La descripción tipo de evento debe tener como máximo :max caracteres.',
			'tev_comentario1.string' => 'El primer comentario ingresado no es válido.',
			'tev_comentario1.min' => 'El primer comentario debe tener como mínimo :min caracteres.',
			'tev_comentario1.max' => 'El primer comentario debe tener como máximo :max caracteres.',
			'tev_comentario2.string' => 'El segundo comentario ingresado no es válido.',
			'tev_comentario2.min' => 'El segundo comentario debe tener como mínimo :min caracteres.',
			'tev_comentario2.max' => 'El segundo comentario debe tener como máximo :max caracteres.',
		];
	}
}
