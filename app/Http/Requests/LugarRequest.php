<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class LugarRequest extends Request {

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

		switch ($this->method()) {
			case 'POST':
				return [
					'lug_abreviatura' => 'required|string|min:2|unique:lugares',
					'lug_nombre' => 'required|string|min:3',
					'lug_tipo' => 'required|in:continente,pais,provincia,ciudad',
					'parent_lug_id' => 'integer'
					];
				break;
			
			case 'PATCH':
				return [
					'lug_abreviatura' => 'required|string|min:2',
					'lug_nombre' => 'required|string|min:3',
					'lug_tipo' => 'required|in:continente,pais,provincia,ciudad',
					'parent_lug_id' => 'integer'
					];
				break;
		}
	}

}
