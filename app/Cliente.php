<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;

class Cliente extends Model
{
	use SearchTrait;
	
    protected $table = 'clientes';
	
	protected $primaryKey = 'clt_id';
	
	public $timestamps = false;

	protected $fillable = [
		'clt_nombre',
		'clt_descripcion',
		'clt_dominio'
	];

	protected $searchFields = [
		'clt_nombre' => 'Nombre',
		'clt_dominio' => 'Dominio',
	];

	public function personalizacion()
    {
        return $this->hasMany('App\PersonalizacionValor', 'clt_id', 'clt_id');
    }

}
