<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jugador;

class PartidoGol extends Model {

	protected $table = 'partido_goles';
	protected $primaryKey = 'gol_id';
	public $timestamps= false;

	protected $fillable = [
		'gol_minuto',
		'gol_auto',
		'gol_jugada',
		'gol_ejecucion',
		'gol_autor',
		'gol_asistencia',
		'par_id',
		'eqp_id',
	];

	public function autor() {
		return $this->belongsTo('App\Jugador','gol_autor','jug_id');
	}

	public function asistente(){
		return $this->belongsTo('App\Jugador','gol_asistencia','jug_id');
	}

	public function partido() {
		return $this->belongsTo('App\Partido','par_id','par_id');
	}
}
