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

}
