<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Partido extends Model {

	protected $table = 'partidos';

	protected $primaryKey = 'par_id';

	public $timestamps = false;
	
	protected $fillable = [
		'fec_id',
		'par_eqp_local',
		'par_eqp_visitante',
		'est_id',
		'par_fecha',
		'par_hora',
		'par_cronica',
		'par_goles_local',
		'par_goles_visitante',
		// par_arbitro_central
		// par_linea1
		// par_linea2
		// par_cuarto_arbitro
	];

	// public function getParHoraAttribute($value)
 //    {
 //    	// return date("H:i p", strtotime("10:20:00"));
 //    	return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
 //        // return Carbon::createFromFormat('HH:mm', $value);
 //    }

	public function fecha() {
		return $this->belongsTo('App\Fecha','fec_id','fec_id');
	}

	public function equipoLocal() {
		return $this->belongsTo('App\Equipo','par_eqp_local','eqp_id');
	}

	public function equipoVisitante() {
		return $this->belongsTo('App\Equipo','par_eqp_visitante','eqp_id');
	}

	public function estadio() {
		return $this->belongsTo('App\Estadio','est_id','est_id');
	}

	public function titulares() {
		return $this->belongsToMany('App\Jugador','partido_jugadores','par_id','jug_id')
					->withPivot('pju_id','pju_amarilla','pju_doble_amarilla','pju_roja','pju_minuto_ingreso','eqp_id')
					->where('pju_minuto_ingreso',0);
	}

	public function jugadoresParticipantes() {
		return $this->belongsToMany('App\Jugador','partido_jugadores','par_id','jug_id')
					->withPivot('pju_id','pju_amarilla','pju_doble_amarilla','pju_roja','pju_minuto_ingreso','eqp_id');
	}

	public function goles() {
		return $this->hasMany('App\PartidoGol','par_id','par_id')
					->with('autor');
	}
}
