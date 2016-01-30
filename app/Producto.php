<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
	protected $primaryKey = 'prd_id';
	public $timestamps = false;

	protected $fillable = [
		'prd_nombre',
		'prd_descripcion',
	];

	protected $nameColumn = 'prd_nombre';

}
