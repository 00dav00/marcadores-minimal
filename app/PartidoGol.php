<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
	];

	
}
