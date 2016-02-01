<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PartidoJugadorTitularRequest extends Request
{

    public static $rules=[
        'par_id' => 'required|integer|exists:partidos,par_id',
        'jug_id' => 'required|integer|exists:jugadores,jug_id',
        'pju_numero_camiseta' => 'integer',
        'pju_juvenil' => 'boolean'
    ];

    public static $messages=[
        'par_id.required' => 'Es obligatorio indicar el partido.',
        'par_id.integer' => 'La clave del partido no es del tipo adecuado.',
        'par_id.exists' => 'La clave del partido no existe en la tabla de partidos.',

        'jug_id.required' => 'Es obligatorio indicar el jugador.',
        'jug_id.integer' => 'La clave del jugador no es del tipo adecuado.',
        'jug_id.exists' => 'La clave del jugador no existe en la tabla de jugadores.',

        'pju_numero_camiseta.integer' => 'El numero de camiseta no es del tipo correcto.',

        'pju_juvenil.boolean' => 'El indicador de juvenil no es del tipo correcto.',
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
