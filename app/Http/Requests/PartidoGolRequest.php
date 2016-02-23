<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PartidoGolRequest extends Request
{

    public static $rules=[
        'gol_minuto'        => 'required|integer',        
        'eqp_id'            => 'required|integer|exists:equipos,eqp_id',
        'par_id'            => 'required|integer|exists:partidos,par_id',
        'gol_jugada'        => 'in:jugada,esquina,contra,libre,penal,otro',
        'gol_ejecucion'     => 'in:disparo,cabeza,muslo,pecho,chilena,tijera,rebote,otro',
        'gol_autor'         => 'required|integer|exists:jugadores,jug_id',
        'gol_asistencia'    => 'integer|exists:jugadores,jug_id',
    ];

    public static $messages=[
        'gol_minuto.required'       => 'Es obligatorio indicar el minuto del gol.',
        'gol_minuto.integer'        => 'El minuto del partido no es del tipo adecuado.',

        'eqp_id.required'           => 'Es obligatorio indicar el equipio favorecido por el gol.',
        'eqp_id.boolean'            => 'La clave del equipo favorecido no es del tipo adecuado.',

        'par_id.required'           => 'Es obligatorio indicar el partido al que pertenece el gol.',
        'par_id.boolean'            => 'La clave del partido no es del tipo adecuado.',

        'gol_jugada.in'             => 'El tipo de jugada debe ser jugada, esquina, contra, libre, penal, otro',
        'gol_ejecucion.in'          => 'El tipo de ejecucion debe ser disparo, cabeza, muslo, pecho, chilena, tijera, rebote, otro',

        'gol_autor.required'        => 'Es obligatorio indicar el autor del gol.',
        'gol_autor.integer'         => 'La clave del autor del gol no es del tipo adecuado.',
        'gol_autor.exists'          => 'La clave del autor del gol no existe en la tabla de jugadores.',

        'gol_asistencia.integer'    => 'La clave del asistente del gol no es del tipo adecuado.',
        'gol_asistencia.exists'     => 'La clave del asistente del gol no existe en la tabla de jugadores.',
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
