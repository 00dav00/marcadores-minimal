<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipoParticipante extends Model {

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'equipos_participantes';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'eqp_id',
		'tor_id',
		];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'eqp_id';

	/**
	 * Indica si el primary key auto incrementa
	 * @var boolean
	 */
	public $incrementing = false;

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

	public function torneo()
	{
		return $this->belongsTo('App\Torneo', 'tor_id', 'tor_id');
	}

	public function equipo()
	{
		return $this->belongsTo('App\Equipo', 'eqp_id', 'eqp_id');
	}

}
