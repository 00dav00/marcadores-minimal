<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model {

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'fases';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'tfa_id',
		'fas_descripcion',
		'tor_id',
		'fas_sumatoria',
		];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'fas_id';

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

	public function tipoFase()
	{
		return $this->belongsTo('App\TipoFase', 'tfa_id', 'tfa_id');
	}

	public function torneo()
	{
		return $this->belongsTo('App\Torneo', 'tor_id', 'tor_id');
	}

	public function fechas()
	{
  		return $this->hasMany('App\Fecha','fas_id','fas_id')
  					->with('partidosConteo');
	}
	 
	public function fechasConteo()
	{
	  	return $this->fechas()//->count();
			    	->selectRaw('fas_id, count(*) as contador')
			    	->groupBy('fas_id');
	}
}
