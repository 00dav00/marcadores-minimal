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

}
