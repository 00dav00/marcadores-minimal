<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class FechaRequest extends Request {

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
			'fas_id' => 'required|integer',
			'fec_numero' => 'required|integer|min:1',
			'fec_fecha_referencia' => 'required|date_format:Y-m-d',
		];
	}

}
