<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;

class Torneo extends Model {

	use SearchTrait, MetaDataTrait;

	protected $table = 'torneos';
	protected $primaryKey = 'tor_id';
	public $timestamps = false;

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

	protected $searchFields = [
		'tor_nombre' => 'Nombre',
		'tor_anio_referencia' => 'Año de referencia',
		'tor_fecha_inicio' => 'Fecha de inicio',
		'tor_fecha_fin' => 'Fecha de fin',
		'tor_tipo_equipos' => 'Tipo de equipos',
		'tor_numero_equipos' => 'Número de equipos',
	];


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

	public function plantillas()
	{
		return $this->belongsToMany('App\Jugador','plantillas_torneo','tor_id','jug_id')
						->withPivot('eqp_id','plt_id','plt_numero_camiseta');
	}

	public function fases()
	{
		return $this->hasMany('App\Fase','tor_id','tor_id')
					->with('tipoFase','fechasConteo');
	}
}
