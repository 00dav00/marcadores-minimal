<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EstadioRequest extends Request {

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
			'est_nombre' => 'required|string|min:3',
			'est_fecha_inauguracion' => 'date_format:Y-m-d',
			'est_foto_por_defecto' => 'image|mimes:jpeg,jpg,bmp,png,gif',
			'est_aforo' => 'integer',
			'lug_id' => 'required|integer',
		];
	}

	public function messages()
	{
		return [
			'est_nombre.required' => 'Es obligatorio indicar el nombre del estadio.',
			'est_nombre.string' => 'El nombre del estadio no es válido.',
			'est_nombre.min' => 'El nombre del estadio debe tener como mínimo :min caracteres.',
			'est_fecha_inauguracion.date_format' => 'El formato de la fecha es incorrecto',
			'est_foto_por_defecto.image' => 'El archivo debe ser una imagen.',
			'est_foto_por_defecto.mimes' => 'El archivo debe ser jpeg, jpg, bmp, png o gif.',
			'est_aforo.integer' => 'El aforo debe ser un número entero',
			'lug_id.required' => 'Es obligatorio indicar la ubicación del estadio.',
			'lug_id.integer' => 'La clave de la ubicación no es del tipo adecuado.',
		];
	}

}
