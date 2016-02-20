<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;

class Equipo extends Model {

	use SearchTrait, MetaDataTrait;

	protected $table = 'equipos';
	protected $primaryKey = 'eqp_id';
	protected $imagePath = 'images/equipos/';
	protected $nameColumn = 'eqp_nombre';
	public $timestamps = false;

	protected $fillable = [
		'eqp_nombre',
		'eqp_fecha_fundacion',
		'eqp_escudo',
		'eqp_twitter',
		'eqp_facebook',
		'eqp_sitioweb',
		'eqp_tipo',
		'lug_id',
		'eqp_nombre_corto',
		'eqp_abreviatura',
	];

	public function nacionalidad() {
		return $this->hasOne('App\Lugar', 'lug_id', 'lug_id');
	}

	public function plantillas() {
		return $this->belongsToMany('App\Jugador','plantillas_torneo','eqp_id','jug_id')
						->withPivot('tor_id','plt_id','plt_numero_camiseta');
	}
	
}
