<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model {

	protected $table = 'partidos';

	protected $primaryKey = 'par_id';

	public $timestamps = false;
	
	protected $fillable = [
		// 'fec_id',
		'par_eqp_local',
		'par_eqp_visitante',
		'est_id',
		'par_fecha',
		'par_hora',
		'par_cronica',
		// par_arbitro_central
		// par_linea1
		// par_linea2
		// par_cuarto_arbitro
	];

	public function fechaTorneo()
	{
		return $this->belongsTo('App\Fecha','fec_id','fec_id');
	}
}
