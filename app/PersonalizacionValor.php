<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalizacionValor extends Model
{
    protected $table = 'personalizacion_valores';
	
	protected $primaryKey = 'pva_id';
	
	public $timestamps = false;

	protected $fillable = [
		'pca_id',
		'clt_id',
		'pva_valor'
	];
}
