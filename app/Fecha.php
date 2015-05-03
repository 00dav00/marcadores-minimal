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
		'fec_fecha_referencia',
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

}
