<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model {

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'jugadores';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'jug_apellido',
		'jug_nombre',
		'jug_apodo',
		'jug_fecha_nacimiento',
		'jug_altura',
		'jug_sitioweb',
		'jug_twitter',
		'jug_foto',
		'lug_id',
		];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'jug_id';

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
