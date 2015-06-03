<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PartidoJugador extends Model {

	protected $table = 'partido_jugadores';

	protected $primaryKey = 'pju_id';

	public $timestamps = false;

	protected $fillable = [
		'par_id',
		'jug_id',
		'pju_minuto_ingreso',
		'pju_reemplazo',
		'pju_amarilla',
		'pju_doble_amarilla',
		'pju_roja',
		'pju_numero_camiseta',
		'pju_juvenil',
	];

	public function partido()
	{
		return $this->belongsTo('App\Partido','par_id','par_id');
	}

}