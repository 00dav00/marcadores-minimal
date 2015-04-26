<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TipoTorneoRequest extends Request {

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
			'ttr_nombre' => 'required|string|min:3',
			'ttr_descripcion' => 'string|min:3'
		];
	}

}
