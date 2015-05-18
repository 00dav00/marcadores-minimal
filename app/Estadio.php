<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;

class Estadio extends Model {

	use SearchTrait;

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
		'pagination' => 50,
	];

	protected $primaryKey = 'est_id';

	public $timestamps = false;

	public function ubicacion()
	{
		return $this->belongsTo('App\Lugar', 'lug_id', 'lug_id');
	}
}
