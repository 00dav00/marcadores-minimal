<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TorneoRequest extends Request {

	public static $rules = [
		'tor_nombre' => 'required|string|min:3',
		'tor_anio_referencia' => 'required|integer',
		'tor_fecha_inicio' => 'required|date_format:Y-m-d',
		'tor_fecha_fin' => 'required|date_format:Y-m-d',
		'tor_tipo_equipos' => 'required|in:seleccion,profesional,amateur',
		'tor_numero_equipos' => 'required|integer|min:2', 
		'lug_id' => 'required|integer|exists:lugares,lug_id',
		'ttr_id' => 'required|integer|exists:tipo_torneos,ttr_id',
	];

	public static $messages = [
		'tor_nombre.required' => 'Es obligatorio indicar el nombre del torneo.',
		'tor_nombre.string' => 'El nombre del torneo no es válido.',
		'tor_nombre.min' => 'El nombre del torneo debe tener como mínimo :min caracteres.',

		'tor_anio_referencia.required' => 'Es obligatorio indicar el año de referencia del torneo.',
		'tor_anio_referencia.integer' => 'El año de referncia del torneo debe ser un número entero',

		'tor_fecha_inicio.required' => 'Es obligatorio indicar la fecha de inicio del torneo.',
		'tor_fecha_inicio.date_format' => 'El formato de la fecha de inicio es incorrecto',

		'tor_fecha_fin.required' => 'Es obligatorio indicar la fecha de finalización del torneo.',
		'tor_fecha_fin.date_format' => 'El formato de la fecha de finalizaciónes incorrecto',

		'tor_tipo_equipos.required' => 'Es obligatorio indicar el tipo de equipos del torneo.',
		'tor_tipo_equipos.in' => 'El tipo de equipos debe ser seleccion, profesional o amateur.',

		'tor_numero_equipos.required' => 'Es obligatorio indicar el número del torneo.',
		'tor_numero_equipos.integer' => 'El número de equipos debe ser un entero',
		'tor_numero_equipos.min' => 'El número de equipos debe mínimo es :min',

		'lug_id.required' => 'Es obligatorio indicar el lugar de referencia del torneo.',
		'lug_id.integer' => 'La clave del lugar de referencia no es del tipo adecuado.',
		'ttr_id.exists' => 'La clave del lugar no existe en la tabla de lugares.',

		'ttr_id.required' => 'Es obligatorio indicar el tipo del torneo.',
		'ttr_id.integer' => 'La clave del tipo de torneo no es del tipo adecuado.',
		'ttr_id.exists' => 'La clave del tipo de torneo no existe en la tabla de tipos de torneo.',
	];

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return static::$rules;
	}


	public function messages()
	{
		return static::$messages;
	}
}
