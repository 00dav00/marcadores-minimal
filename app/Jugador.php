<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;
use App\Libraries\ImageTrait;

class Jugador extends Model
{
	use SearchTrait, MetaDataTrait, ImageTrait;

    protected $table = 'jugadores';
	protected $primaryKey = 'jug_id';
	public $timestamps = false;

	protected $fillable = [
		'jug_apellido',
		'jug_nombre',
		'jug_apodo',
		'jug_fecha_nacimiento',
		'jug_altura',
		'jug_sitioweb',
		'jug_twitter',
		'jug_foto',
		'jug_nacionalidad',
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
	 * Define el tamaño de las imagenes
	 */
	public function __construct(array $attributes = array())
	{
	 	parent::__construct($attributes);
		$this->_setImageSize(300, 200);
	}

	/**
	 * Obtener la nacionalidad de un jugador
	 * @return object relacion con la tabla lugares
	 */
	public function nacionalidad()
	{
		return $this->hasOne('App\Lugar', 'lug_id', 'jug_nacionalidad');
	}


	public function getTableAttribute()
  	{
   		return $this->table;
  	}

  	/**
	 * Obtener el path publico del campo donde se guarda la imagen
	 * @return string path publico de la iamgen
	 */
  	public function getPicturePath()
  	{
  		if (!isset($this->jug_foto) || $this->jug_foto = '')
  			return null;
  		
  		return public_path( $this->jug_foto );
  	}
}
