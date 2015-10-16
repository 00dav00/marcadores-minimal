<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;

class Lugar extends Model {

	use SearchTrait;

	/**
	 * Nombre de la tabla en donde se guardan los lugares
	 * @var string
	 */
	protected $table = 'lugares';

	/**
	 * Campos que se deben llenar
	 * @var array
	 */
	protected $fillable = [
		'lug_abreviatura',
		'lug_nombre',
		'lug_tipo',
		'parent_lug_id'
	];

	/**
	 * Columna primary key
	 * @var string
	 */
	protected $primaryKey = 'lug_id';

	/**
	 * No se van a utilizar timestamps
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Un lugar puede ser hijo de otro lugar
	 * @return object relacion uno a uno
	 */
	public function lugarPadre()
	{
		return $this->hasOne('App\Lugar', 'lug_id', 'parent_lug_id');
	}

	/**
	 * Obtener la nacionalidad de un jugador
	 * @return object relacion con la tabla lugares
	 */
	public function equipo()
	{
		return $this->belongsToMany('App\Equipo', 'lug_id', 'lug_id');
	}

}
