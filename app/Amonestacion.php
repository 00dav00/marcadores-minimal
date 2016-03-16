<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amonestacion extends Model {

    protected $table = 'amonestaciones';
	protected $primaryKey = 'amn_id';
	public $timestamps= false;

	protected $fillable = [
		'par_id',
		'jug_id',
		'eqp_id',
		'amn_tipo',
		'amn_minuto',
	];

	public function jugador() {
		return $this->belongsTo('App\Jugador','jug_id','jug_id');
	}
}
