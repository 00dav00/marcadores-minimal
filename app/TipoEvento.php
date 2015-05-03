<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model {

	protected $table = 'tipos_evento';

	protected $fillable = [
		'tev_nombre',
		'tev_descripcion',
		'tev_comentario1',
		'tev_comentario2',
	];

	protected $primaryKey = 'tev_codigo';

	public $timestamps = false;


}
