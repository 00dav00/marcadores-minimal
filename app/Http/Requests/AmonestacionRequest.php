<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AmonestacionRequest extends Request {

    public static $rules=[
        'par_id'                => 'required|integer|exists:partidos,par_id',
        'jug_id'                => 'required|integer|exists:jugadores,jug_id',
        'eqp_id'                => 'required|integer|exists:equipos,eqp_id',
        'amn_tipo'              => 'required|in:amarilla,roja',
        'amn_minuto'            => 'required|integer|min:1',
    ];

    public static $messages=[
        'par_id.required'               => 'Es obligatorio indicar el partido.',
        'par_id.integer'                => 'La clave del partido no es del tipo adecuado.',
        'par_id.exists'                 => 'La clave del partido no existe en la tabla de partidos.',

        'jug_id.required'               => 'Es obligatorio indicar el jugador.',
        'jug_id.integer'                => 'La clave del jugador no es del tipo adecuado.',
        'jug_id.exists'                 => 'La clave del jugador no existe en la tabla de jugadores.',

        'eqp_id.required'               => 'Es obligatorio indicar el equipo.',
        'eqp_id.integer'                => 'La clave del equipo no es del tipo adecuado.',
        'eqp_id.exists'                 => 'La clave del equipo no existe en la tabla de equipos.',

        'amn_tipo.required'             => 'Es obligatorio indicar el tipo de amonestacion.',
        'amn_tipo.in'                   => 'El tipo de amonestacion debe ser amarilla o roja.',

        'amn_minuto.required'           => 'Es obligatorio indicar el minuto de la amonestacion.',
        'amn_minuto.integer'            => 'El minuto de ingreso no es del tipo correcto.',
        'amn_minuto.min'                => 'El minuto de ingreso debe ser al menos 1.',
    ];

    public function authorize() {
        return true;
    }

    public function rules() {
        return static::$rules;
    }

    public function messages() {
        return static::$messages;
    }
}
