<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalizacionCampo extends Model
{
    protected $table = 'personalizacion_campos';
	
	protected $primaryKey = 'pca_id';
	
	public $timestamps = false;

	protected $fillable = [
		'pca_nombre',
		'pca_descripcion'
	];
}
