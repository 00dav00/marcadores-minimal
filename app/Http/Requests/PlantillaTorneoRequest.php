<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlantillaTorneoRequest extends Request {

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
			'plt_numero_camiseta' => 'required|integer',
			'eqp_id' => 'required|integer',
			'jug_id' => 'required|integer',
			'tor_id' => 'required|integer',
		];
	}

}
