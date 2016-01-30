<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PenalizacionTorneo extends Model {

	protected $table = 'penalizaciones_torneo';
	protected $primaryKey = 'ptr_id';
	public $timestamps = false;

	protected $fillable = [
		'eqp_id',
		'fas_id',
		'ptr_puntos',
		'ptr_motivo'
	];


	public function fase()
	{
		return $this->belongsTo('App\Fase', 'fas_id', 'fas_id')
					->with('torneo');

	}

	public function equipo()
	{
		return $this->belongsTo('App\Equipo', 'eqp_id', 'eqp_id');
	}
}
