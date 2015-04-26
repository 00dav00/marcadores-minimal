<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTorneo extends Model {

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'tipo_torneos';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'ttr_nombre',
		'ttr_descripcion',
		];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'ttr_codigo';

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Obtener la nacionalidad de un jugador
	 * @return object relacion con la tabla lugares
	 */
	public function torneo()
	{
		return $this->belongsToMany('App\Torneo', 'ttr_codigo', 'ttr_codigo');
	}

}
