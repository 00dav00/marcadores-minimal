<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class FaseRequest extends Request {

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
			'tfa_codigo' => 'required|integer',
			'fas_descripcion' => 'required|string|min:3',
			'tor_id' => 'required|integer',
		];
	}

}
