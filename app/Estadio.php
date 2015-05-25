<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;


class Estadio extends Model {

	use SearchTrait, MetaDataTrait;

	protected $table = 'estadios';

	protected $fillable = [
		'est_nombre',
		'est_fecha_inauguracion',
		'est_foto_por_defecto',
		'est_aforo',
		'lug_id',
	];

	protected $searchArray = [
		'columns' => [
				'est_nombre' => 'Nombre',
				'est_fecha_inauguracion' => 'Fecha de inauguración',
			],
		'joins' => [
				'ubicacion',
			],
	];

	protected $primaryKey = 'est_id';

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

	public function ubicacion()
	{
		return $this->belongsTo('App\Lugar', 'lug_id', 'lug_id');
	}
}
