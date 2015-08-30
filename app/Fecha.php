<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fecha extends Model {

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'fechas';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'fas_id',
		'fec_numero',
		'fec_estado'
		];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'fec_id';

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

	public function fase()
	{
		return $this->belongsTo('App\Fase', 'fas_id', 'fas_id');
	}

	public function partidos()
	{
		return $this->hasMany('App\Partido','fec_id','fec_id');
	}

	public function partidosConteo()
	{
	  	return $this->partidos()//->count();
			    	->selectRaw('par_id, count(*) as contador')
			    	->groupBy('par_id');
	}

	public function equipoLocal()
	{
		return $this->belongsTo('App\Equipo','par_eqp_local','eqp_id');
	}

	public function equipoVisitante()
	{
		return $this->belongsTo('App\Equipo','par_eqp_visitante','eqp_id');
	}
}
