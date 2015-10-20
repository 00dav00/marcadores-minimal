<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PenalizacionTorneo extends Model {

	protected $table = 'penalizaciones_torneo';
	protected $primaryKey = 'tor_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'eqp_id',
		'fas_id',
		'ptr_puntos',
		'ptr_motivo'
	];


	public function fase()
	{
		return $this->belongsTo('App\Fase', 'fas_id', 'fas_id');
	}

	public function equipo()
	{
		return $this->belongsTo('App\Equipo', 'eqp_id', 'eqp_id');
	}

	public function torneo()
	{
		return $this->belongsTo('App\Torneo', 'tor_id', 'tor_id');
	}

}
