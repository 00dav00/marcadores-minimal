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

}
