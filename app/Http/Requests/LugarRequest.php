<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class LugarRequest extends Request {

	public static $rules = [
		'lug_abreviatura' => 'required|string|min:2',
		'lug_nombre' => 'required|string|min:3',
		'lug_tipo' => 'required|in:continente,pais,provincia,ciudad',
		'parent_lug_id' => 'integer|exists:lugares,lug_id'
	];

	public static $messages = [
		'lug_abreviatura.required' => 'Es obligatorio indicar la abreviatura del lugar.',
		'lug_abreviatura.string' => 'El formato de la abreviatura es incorrecto',
		'lug_abreviatura.min' => 'La abreviatura del lugar debe tener como mínimo :min caracteres.',

		'lug_nombre.required' => 'Es obligatorio indicar el nombre del lugar.',
		'lug_nombre.string' => 'El formato del nombre es incorrecto',
		'lug_nombre.min' => 'El nombre del lugar debe tener como mínimo :min caracteres.',

		'lug_tipo.required' => 'Es obligatorio indicar el tipo de lugar.',
		'lug_tipo.in' => 'El tipo de lugar debe ser continente,pais o ciudad.',

		'parent_lug_id.integer' => 'La clave del lugar padre no es del tipo adecuado.',
		'parent_lug_id.exists' => 'La clave del lugar padre no existe en la tabla de lugares.',
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
