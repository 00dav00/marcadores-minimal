<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlantillaTorneoRequest extends Request
{

    public static $rules = [
        'plt_numero_camiseta' => 'required|integer',
        'eqp_id' => 'required|integer|exists:equipos,eqp_id',
        'jug_id' => 'required|integer|exists:jugadores,jug_id',
        'tor_id' => 'required|integer|exists:torneos,tor_id',
    ];

    public static $messages = [
        'plt_numero_camiseta.required' => 'Es obligatorio ingresar el número de camiseta.',
        'plt_numero_camiseta.integer' => 'El número de camiseta debe ser un número entero',

        'eqp_id.required' => 'Es obligatorio ingresar el equipo.',
        'eqp_id.integer' => 'La clave del equipo no es del tipo adecuado.',
        'eqp_id.exists' => 'La clave de la equipo no existe en la tabla de equipos.',

        'jug_id.required' => 'Es obligatorio ingresar el jugador.',
        'jug_id.integer' => 'La clave del jugador no es del tipo adecuado.',
        'jug_id.exists' => 'La clave del jugador no existe en la tabla de jugadores.',

        'tor_id.required' => 'Es obligatorio ingresar el torneo.',
        'tor_id.integer' => 'La clave del tornero no es del tipo adecuado.',
        'tor_id.exists' => 'La clave del torneo no existe en la tabla de torneos.',
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

    public function rules()
    {
        return static::$rules;
    }    

    public function messages()
    {
        return static::$messages;
    }
}
