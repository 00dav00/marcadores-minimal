<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libraries\SearchTrait;
use App\Libraries\MetaDataTrait;

class Torneo extends Model {

	use SearchTrait, MetaDataTrait;

	protected $table = 'torneos';
	protected $primaryKey = 'tor_id';
	public $timestamps = false;

	protected $fillable = [
		'tor_nombre',
		'tor_anio_referencia',
		'tor_fecha_inicio',
		'tor_fecha_fin',
		'tor_tipo_equipos',
		'tor_numero_equipos',
		'lug_id',
		'ttr_id'
	];

	protected $searchFields = [
		'tor_nombre' => 'Nombre',
		'tor_anio_referencia' => 'Año de referencia',
		'tor_fecha_inicio' => 'Fecha de inicio',
		'tor_fecha_fin' => 'Fecha de fin',
		'tor_tipo_equipos' => 'Tipo de equipos',
		'tor_numero_equipos' => 'Número de equipos',
	];


	public function contieneFaseAcumulada () {
		return $this->fases
					->reduce( function ($carry, $item) { return $carry || $item->fas_acumulada; }, false);
	}

	public function obtenerArraySimplificadoFases() {
		$fases = [];

		foreach ($this->fases as $fase) {
            $fases[$fase->fas_id] = [
                'fas_id' => $fase->fas_id,
                'fas_descripcion' => $fase->fas_descripcion
                ];
        }

        if ( $this->contieneFaseAcumulada() ) {
            $fases['acumulada'] = [
                'fas_id' => 'acumulada',
                'fas_descripcion' => 'Acumulada'
                ];
        }

        return $fases;
	}

	public function lugar()
	{
		return $this->hasOne('App\Lugar', 'lug_id', 'lug_id');
	}

	public function tipoTorneo()
	{
		return $this->hasOne('App\TipoTorneo', 'ttr_id', 'ttr_id');
	}

	public function equiposParticipantes()
	{
		return $this->belongsToMany('App\Equipo','equipos_participantes','tor_id','eqp_id');
	}

	public function plantillas()
	{
		return $this->belongsToMany('App\Jugador','plantillas_torneo','tor_id','jug_id')
						->withPivot('eqp_id','plt_id','plt_numero_camiseta');
	}

	public function fases()
	{
		return $this->hasMany('App\Fase','tor_id','tor_id')
					->with('tipoFase','fechasConteo');
	}

	public function penalizaciones()
	{
		return $this->hasManyThrough('App\PenalizacionTorneo','App\Fase','tor_id','fas_id');
	}
}
