<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;

class Equipo extends Model {

	use SearchTrait;

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'equipos';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'eqp_nombre',
		'eqp_fecha_fundacion',
		'eqp_escudo',
		'eqp_twitter',
		'eqp_facebook',
		'eqp_sitioweb',
		'eqp_tipo',
		'lug_id'
	];

	protected $searchArray = [
		'columns' => [
				'eqp_nombre' => 'Nombre',
				'eqp_fecha_fundacion' => 'Fecha de fundación',
				'eqp_tipo' => 'Tipo',
			],
		'joins' => [
				'nacionalidad',
			],
		'pagination' => 50,
	];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'eqp_id';

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Obtener la nacionalidad de un jugador
	 * @return object relacion con la tabla lugares
	 */
	public function nacionalidad()
	{
		return $this->hasOne('App\Lugar', 'lug_id', 'lug_id');
	}
}
