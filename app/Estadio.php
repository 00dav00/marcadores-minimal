<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadio extends Model {

	protected $table = 'estadios';

	protected $fillable = [
		'est_nombre',
		'est_fecha_inauguracion',
		'est_foto_por_defecto',
		'est_aforo',
		'lug_id',
	];

	protected $primaryKey = 'est_id';

	public $timestamps = false;

	public function ubicacion()
	{
		return $this->belongsTo('App\Lugar', 'lug_id', 'lug_id');
	}
}
