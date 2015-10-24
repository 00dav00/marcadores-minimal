<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;

class Cliente extends Model
{
    protected $table = 'clientes';
	
	protected $primaryKey = 'clt_id';
	
	public $timestamps = false;

	protected $fillable = [
		'clt_nombre',
		'clt_descripcion',
		'clt_dominio'
	];

}