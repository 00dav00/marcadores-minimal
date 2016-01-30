<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClienteRequest extends Request
{
    public static $rules = [
            'clt_nombre' => 'required|string|min:3',
            'clt_descripcion' => 'string|min:3',
            'clt_dominio' => 'required|url',
    ];

    public static $messages = [
            'clt_nombre.required' => 'Es obligatorio indicar el nombre del cliente.',
            'clt_nombre.string' => 'El nombre del cliente no es válido.',
            'clt_nombre.min' => 'El nombre del cliente debe tener como mínimo :min caracteres.',
            'clt_descripcion.string' => 'La descripción del cliente no es válida.',
            'clt_descripcion.min' => 'La descripción del cliente debe tener como mínimo :min caracteres.',
            'clt_dominio.required' => 'Es obligatorio indicar el nombre del dominio del cliente.',
            'clt_dominio.url' => 'El dominio del cliente no es válido.',
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
