<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PersonalizacionValorRequest extends Request
{

	public static $rules = [
		'clt_id' => 'required|integer|exists:clientes,clt_id',
		'pva_valor' => 'required|string|min:4',
		'pca_id' => 'required|integer|between:1,6',
	];

	public static $messages = [
		'clt_id.required' => 'Es obligatorio indicar el cliente',
		'clt_id.integer' => 'El id del cliente no es válido.',
		'clt_id.exists' => 'El cliente no existe',
		'pva_valor.required' => 'Es obligatorio indicar el valor del campo',
		'pva_valor.string' => 'El valor del campo no es válido.',
		'pva_valor.min' => 'El valor del campo debe tener como mínimo :min caracteres.',
		'pca_id.required' => 'Es obligatorio indicar el id del campo.',
		'pca_id.integer' => 'El id del campo no es valido.',
		'pca_id.between' => 'El id del campo debe tener valores entre 1 a 6.',
	];

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
    	return static::$rules;
    }

    /**
     * Messages to show
     * @return array
     */
    public function messages()
    {
        return static::$messages;
    }
}
