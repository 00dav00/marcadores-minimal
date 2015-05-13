<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFase extends Model {

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'tipo_fases';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'tfa_nombre',
		'tfa_descripcion',
		];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'tfa_id';

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

}
