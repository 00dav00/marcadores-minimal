<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class JugadorRequest extends Request {

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
			'jug_apellido' => 'required|string|min:3',
			'jug_nombre' => 'required|string|min:3',
			'jug_apodo' => 'string|min:3',
			'jug_fecha_nacimiento' => 'date_format:Y-m-d',
			'jug_altura' => 'integer',
			'jug_sitioweb' => 'url',
			'jug_twitter' => 'string',
			'jug_foto' => 'image|mimes:jpeg,jpg,bmp,png,gif',
			'lug_id' => 'required|integer',
		];
	}

	public function messages(){
		return [
			'jug_apellido.required' => 'Es obligatorio indicar el apellido del jugador.',
			'jug_apellido.string' => 'El apellido del jugador no es válido.',
			'jug_apellido.min' => 'El apellido del jugador debe tener como mínimo :min caracteres.',
			'jug_nombre.required' => 'Es obligatorio indicar el nombre del jugador.',
			'jug_nombre.string' => 'El nombre del jugador no es válido.',
			'jug_nombre.min' => 'El nombre del jugador debe tener como mínimo :min caracteres.',
			'jug_apodo.string' => 'El apodo del jugador no es válido.',
			'jug_apodo.min' => 'El apodo del jugador debe tener como mínimo :min caracteres.',
			'jug_fecha_nacimiento.date_format' => 'El formato de la fecha de nacimiento es incorrecto',
			'jug_altura.integer' => 'La altura del jugador debe ser un número entero',
			'jug_sitioweb.url' => 'El formato del sitio web es incorrecto',
			'jug_twitter.string' => 'El twitter del jugador no es válido.',
			'jug_foto.image' => 'El archivo debe ser una imagen.',
			'jug_foto.mimes' => 'El archivo debe ser jpeg, jpg, bmp, png o gif.',
			'lug_id.required' => 'Es obligatorio indicar la nacionalidad del jugador.',
			'lug_id.integer' => 'La clave de la nacionalidad no es del tipo adecuado.',
		];
	}

}
