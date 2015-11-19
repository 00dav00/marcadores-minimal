<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;
use App\Libraries\ImageTrait;

class Auspiciante extends Model
{
    use SearchTrait, MetaDataTrait, ImageTrait;

    protected $table = 'auspiciantes';
	protected $primaryKey = 'aus_id';
	public $timestamps = false;

	protected $fillable = [
		'aus_nombre',
		'aus_sitioweb',
		'aus_imagen',
	];

	/**
	 * path donde se guardan las imagenes
	 * @var string
	 */
	protected $imagePath = 'images/auspiciantes/';

	/**
	 * nombre para consultas ajax
	 * @var string
	 */
	protected $nameColumn = 'aus_nombre';


	/**
	 * Array de columnas usadas para busqueda
	 * @var string
	 */
	protected $searchFields = [
		'aus_nombre' => 'Nombre',
	];	

	/**
	 * Define el tamaño de las imagenes
	 */
	public function __construct(array $attributes = array())
	{
	 	parent::__construct($attributes);
		$this->_setImageSize(300, 200);
	}

	public function getPicturePath()
  	{
  		if (!isset($this->aus_imagen) || $this->aus_imagen = '')
  			return null;

  		return public_path( $this->aus_imagen );
  	}

}
