<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model {

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'torneos';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'tor_nombre',
		'tor_anio_referencia',
		'tor_fecha_inicio',
		'tor_fecha_fin',
		'tor_tipo_equipos',
		'tor_numero_equipos',
		'lug_id',
		'ttr_id'
		];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'tor_id';

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Obtener la nacionalidad de un jugador
	 * @return object relacion con la tabla lugares
	 */
	public function lugar()
	{
		return $this->hasOne('App\Lugar', 'lug_id', 'lug_id');
	}

	/**
	 * Obtener el tipo de torneo
	 * @return object relacion con la tabla tipo de torneo
	 */
	public function tipoTorneo()
	{
		return $this->hasOne('App\TipoTorneo', 'ttr_id', 'ttr_id');
	}

	public function equiposParticipantes()
	{
		return $this->belongsToMany('App\Equipo','equipos_participantes','tor_id','eqp_id');
	}

	public function plantilla()
	{
		return $this->belongsToMany('App\Jugador','plantillas_torneo','tor_id','jug_id')
						->withPivot('eqp_id');						
	}

}
