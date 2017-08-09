<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PenalizacionTorneoRequest extends Request {

  public static $rules = [
    'tor_id' => 'required|integer|exists:torneos,tor_id',
    'eqp_id' => 'required|integer|exists:equipos,eqp_id',
    'fas_id' => 'required|integer|exists:fases,fas_id',
    'ptr_puntos' => 'required|integer',
    'ptr_motivo' => 'string|min:3'
  ];

  public static $messages = [
    'eqp_id.required' => 'Es obligatorio indicar el equipo.',
      'eqp_id.integer' => 'La clave del equipo no es del tipo adecuado.',
      'fas_id.required' => 'Es obligatorio indicar la fase.',
      'fas_id.integer' => 'La clave de la fase no es del tipo adecuado.',
      'ptr_puntos.required' => 'Es obligatorio indicar la cantidad de puntos.',
      'ptr_puntos.integer' => 'Los puntos especificados no son del tipo adecuado.',
      'ptr_motivo.string' => 'El motivo no es del tipo adecuado.',
      'ptr_motivo.min' => 'El motivo no tiene la longitud minima de 3.',
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
