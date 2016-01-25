<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalizacionValor extends Model
{
    protected $table = 'personalizacion_valores';
	
	protected $primaryKey = 'pva_id';
	
	protected $campos = [
		[
			'id' => 1,
			'nombre' => 'color_fondo',
			'descripcion' => 'Color de fondo',
			'valor_default' => '#FFFFFF'
		],
		[
			'id' => 2,
			'nombre' => 'color_texto_titulo',
			'descripcion' => 'Color del texto del titulo',
			'valor_default' => '#000000'
		],
		[
			'id' => 3,
			'nombre' => 'color_header',
			'descripcion' => 'Color de header de la tabla',
			'valor_default' => '#FFFFFF'
		],
		[
			'id' => 4,
			'nombre' => 'color_texto_header',
			'descripcion' => 'Color de texto del header de la tabla',
			'valor_default' => '#000000'
		],
		[
			'id' => 4,
			'nombre' => 'color_texto_body',
			'descripcion' => 'Color del texto',
			'valor_default' => '#000000'
		],	
		[
			'id' => 5,
			'nombre' => 'color_boton',
			'descripcion' => 'Color de los botones',
			'valor_default' => '#FFFFFF'
		],
		[
			'id' => 6,
			'nombre' => 'color_texto_boton',
			'descripcion' => 'Color de texto de los botones',
			'valor_default' => '#000000'
		],		
	];

	public $timestamps = false;

	protected $fillable = [
		'pca_id',
		'clt_id',
		'pva_valor'
	];

	public function getCampos()
	{
		return $this->campos;
	}

	public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'clt_id', 'clt_id');
    }
}
