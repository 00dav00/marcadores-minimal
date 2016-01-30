<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;
use App\Libraries\ImageTrait;

class Estadio extends Model {

	use SearchTrait, MetaDataTrait, ImageTrait;

	protected $table = 'estadios';

	protected $fillable = [
		'est_nombre',
		'est_fecha_inauguracion',
		'est_foto_por_defecto',
		'est_aforo',
		'lug_id',
	];

	protected $primaryKey = 'est_id';

	protected $searchFields = [
		'est_nombre' => 'Nombre', 
		'est_fecha_inauguracion' => 'Fecha de inauguración'
	];

	/**
	 * path donde se guardan las imagenes
	 * @var string
	 */
	protected $imagePath = 'images/estadios/';

	/**
	 * nombre para consultas ajax
	 * @var string
	 */
	protected $nameColumn = 'est_nombre';

	public $timestamps = false;

	/**
	 * Define el tamaño de las imagenes
	 */
	public function __construct(array $attributes = array())
	{
	 	parent::__construct($attributes);
		$this->_setImageSize(300, 200);
	}

	public function ubicacion()
	{
		return $this->belongsTo('App\Lugar', 'lug_id', 'lug_id');
	}
}
