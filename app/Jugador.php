<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;

class Jugador extends Model
{
	public $timestamps = false;
    protected $table = 'jugadores';
	protected $primaryKey = 'jug_id';

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
	 * Array de columnas usadas por el trait de busqueda
	 * @var string
	 */
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
	 * Obtener la nacionalidad de un jugador
	 * @return object relacion con la tabla lugares
	 */
	public function nacionalidad()
	{
		return $this->hasOne('App\Lugar', 'jug_nacionalidad', 'lug_id');
	}
}
