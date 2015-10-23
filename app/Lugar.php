<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;

class Lugar extends Model {

	use SearchTrait;

	protected $table = 'lugares';
	protected $primaryKey = 'lug_id';
	public $timestamps = false;


	protected $fillable = [
		'lug_abreviatura',
		'lug_nombre',
		'lug_tipo',
		'parent_lug_id'
	];


	public $searchFields = [
		'lug_abreviatura' => 'Abreviatura', 
		'lug_nombre' => 'Nombre'
	];


	public function lugarPadre()
	{
		return $this->hasOne('App\Lugar', 'lug_id', 'parent_lug_id');
	}

	public function equipos()
	{
		return $this->hasMany('App\Equipo', 'lug_id', 'lug_id');
	}

}
