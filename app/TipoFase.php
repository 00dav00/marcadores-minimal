<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFase extends Model {

	protected $table = 'tipo_fases';
	protected $primaryKey = 'tfa_id';
	public $timestamps = false;

	protected $fillable = [
		'tfa_nombre',
		'tfa_descripcion',
	];

}
