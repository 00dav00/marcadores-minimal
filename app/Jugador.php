<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;

class Jugador extends Model {

	use SearchTrait, MetaDataTrait;

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

	protected $searchArray = [
		'columns' => [
				'jug_apellido' => 'Apellido',
				'jug_nombre' => 'Nombre',
				'jug_apodo' => 'Apodo',
			],
		'joins' => [
				'nacionalidad',
			],
	];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'jug_id';

	/**
	 * path donde se guardan las imagenes
	 * @var string
	 */
	protected $imagePath = 'images/jugadores/';

	/**
	 * nombre para consultas ajax
	 * @var string
	 */
	protected $nameColumn = 'jug_nombre';

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
