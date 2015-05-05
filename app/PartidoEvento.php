<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PartidoEvento extends Model {

	protected $table = 'partido_eventos';

	protected $primaryKey = 'pev_id';

	public $timestamps= false;

	protected $fillable = [
		'pev_minuto',
		'pev_jugador1',
		'pev_evento1',
		'pev_jugador2',
		'pev_evento2',
		'pev_metadata',
	];

}
