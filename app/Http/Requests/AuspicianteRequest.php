<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AuspicianteRequest extends Request
{

    public static $rules = [
        'aus_nombre' => 'required|string|min:3',
        'aus_sitioweb' => 'url',
        'aus_imagen' => 'required|image|mimes:jpeg,jpg,bmp,png,gif',
    ];

    public static $messages = [
        'aus_nombre.required' => 'Es obligatorio indicar el nombre del auspiciante.',
        'aus_nombre.string' => 'El nombre del auspiciante no es válido.',
        'aus_nombre.min' => 'El nombre del auspiciante debe tener como mínimo :min caracteres.',
        'aus_sitioweb.url' => 'El formato del sitio web es incorrecto',
        'aus_imagen.required' => 'Es obligatorio subir una imagen del auspiciante.',
        'aus_imagen.image' => 'El archivo debe ser una imagen.',
        'aus_imagen.mimes' => 'El archivo debe ser jpeg, jpg, bmp, png o gif.',
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
