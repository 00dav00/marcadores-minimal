<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\MetaDataTrait;

class PlantillaTorneo extends Model {

	use MetaDataTrait;

	protected $table = 'plantillas_torneo';
	protected $primaryKey = 'plt_id';
	public $timestamps = false;

	protected $fillable = [
		'plt_numero_camiseta',
		'eqp_id',
		'jug_id',
		'tor_id',
	];

	public function torneo()
	{
		return $this->belongsTo('App\Torneo', 'tor_id', 'tor_id');
	}

	public function equipo()
	{
		return $this->belongsTo('App\Equipo', 'eqp_id', 'eqp_id');
	}

	public function jugador()
	{
		return $this->belongsTo('App\Jugador', 'jug_id', 'jug_id');
	}

}
