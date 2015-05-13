<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EquipoRequest extends Request {

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
			'eqp_nombre' => 'required|string|min:3',
			'eqp_fecha_fundacion' => 'date_format:Y-m-d',
			'eqp_sitioweb' => 'url',
			'eqp_tipo' => 'required|in:seleccion,profesional,amateur',
			'lug_id' => 'required|integer'
		];
	}

	public function messages()
	{
		return [
			'eqp_nombre.required' => 'Es obligatorio ingresar el nombre equipo.',
			'eqp_fecha_fundacion.date_format' => 'El formato de la fecha es incorrecto',
			'eqp_sitioweb.url' => 'El formato del sitio web es incorrecto',
			'eqp_tipo.required' => 'Es obligatorio ingresar el tipo equipo.',
			'eqp_tipo.in' => 'El tipo equipo debe ser seleccion, profesional oamateur.',
			'lug_id.required' => 'Es obligatorio ingresar el lugar de origen del equipo.',
		];
	}

}
