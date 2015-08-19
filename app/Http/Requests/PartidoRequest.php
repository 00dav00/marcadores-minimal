<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PartidoRequest extends Request {

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
			'par_eqp_local' => 'required|integer',
			'par_eqp_visitante' => 'required|integer|different:par_eqp_local',
			'est_id' => 'integer',
			'par_fecha' => 'date',
			'par_hora' => 'date',
			'par_cronica' => 'url',
			// 'par_arbitro_central' => 'required|integer',
			// 'par_linea1' => 'required|integer',
			// 'par_linea2' => 'required|integer',
			// 'par_cuarto_arbitro' => 'required|integer',
			'goles_visitante' => 'integer',
			'goles_local' => 'integer',
		];
	}


	public function messages()
	{
		return [
			'par_eqp_local.required' => 'Es obligatorio indicar el equipo local.',
			'par_eqp_local.integer' => 'La clave del equipo local no es del tipo adecuado.',
			'par_eqp_visitante.required' => 'Es obligatorio indicar el equipo visitante.',
			'par_eqp_visitante.integer' => 'La clave del equipo visitante no es del tipo adecuado.',
			'par_eqp_visitante.different' => 'Los equipos local y visitante deben ser distintos.',
			'est_id.required' => 'Es obligatorio indicar el estadio.',
			'est_id.integer' => 'La clave del estadio no es del tipo adecuado.',
			'par_fecha.date_format' => 'El formato de la fecha es incorrecto',
			'par_hora.regex' => 'El formato de la hora es incorrecto',
			'par_cronica.url' => 'El formato de la firección de la crónica es incorrecto',
			// 'par_arbitro_central.required' => 'Es obligatorio indicar el árbitro central del partido.',
			// 'par_arbitro_central.integer' => 'La clave del árbitro central no es del tipo adecuado.',
			// 'par_linea1.required' => 'Es obligatorio indicar el línea 1 del partido.',
			// 'par_linea1.integer' => 'La clave del línea 1 no es del tipo adecuado.',
			// 'par_linea2.required' => 'Es obligatorio indicar línea 2 del partido.',
			// 'par_linea2.integer' => 'La clave del línea 2 no es del tipo adecuado.',
			// 'par_cuarto_arbitro.required' => 'Es obligatorio indicar el cuarto árbitro del partido.',
			// 'par_cuarto_arbitro.integer' => 'La clave del cuarto árbitro no es del tipo adecuado.',
		];
	}
}
