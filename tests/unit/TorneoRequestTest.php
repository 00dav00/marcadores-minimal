<?php


use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\TorneoRequest;

class TorneoRequestTest extends TestCase
{	
    use WithoutMiddleware;

    private $rules;
    private $messages;

    private $lugar;
    private $tipoTorneo;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
    }

    public function setUp()
    {
    	parent::createApplication();
        $this->rules = TorneoRequest::$rules;
    	$this->messages = TorneoRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => '', 'tor_anio_referencia' => '', 'tor_fecha_inicio' => '', 'tor_fecha_fin' => '', 
            'tor_tipo_equipos' => '', 'tor_numero_equipos' => '', 'lug_id' => '', 'ttr_id' => '',]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

        $this->assertTrue($validator->errors()->has('tor_nombre'),'Se esperaba que exista clave tor_nombre');
        $this->assertCount(1, $validator->errors()->get('tor_nombre'),'Se esperaba que exista 1 error en la clave tor_nombre');
        $this->assertTrue($validator->errors()->has('tor_anio_referencia'),'Se esperaba que exista clave tor_anio_referencia');
        $this->assertCount(1, $validator->errors()->get('tor_anio_referencia'),'Se esperaba que exista 1 error en la clave tor_anio_referencia');
        $this->assertTrue($validator->errors()->has('tor_fecha_inicio'),'Se esperaba que exista clave tor_fecha_inicio');
        $this->assertCount(1, $validator->errors()->get('tor_fecha_inicio'),'Se esperaba que exista 1 error en la clave tor_fecha_inicio');
        $this->assertTrue($validator->errors()->has('tor_fecha_fin'),'Se esperaba que exista clave tor_fecha_fin');
        $this->assertCount(1, $validator->errors()->get('tor_fecha_fin'),'Se esperaba que exista 1 error en la clave tor_fecha_fin');
        $this->assertTrue($validator->errors()->has('tor_tipo_equipos'),'Se esperaba que exista clave tor_tipo_equipos');
        $this->assertCount(1, $validator->errors()->get('tor_tipo_equipos'),'Se esperaba que exista 1 error en la clave tor_tipo_equipos');
        $this->assertTrue($validator->errors()->has('tor_numero_equipos'),'Se esperaba que exista clave tor_numero_equipos');
        $this->assertCount(1, $validator->errors()->get('tor_numero_equipos'),'Se esperaba que exista 1 error en la clave tor_numero_equipos');
        $this->assertTrue($validator->errors()->has('lug_id'),'Se esperaba que exista clave lug_id');
        $this->assertCount(1, $validator->errors()->get('lug_id'),'Se esperaba que exista 1 error en la clave lug_id');
        $this->assertTrue($validator->errors()->has('ttr_id'),'Se esperaba que exista clave ttr_id');
        $this->assertCount(1, $validator->errors()->get('ttr_id'),'Se esperaba que exista 1 error en la clave ttr_id');

        $this->assertCount(8, $validator->errors()->all(), 'Se esperaban 8 errores de validacion');
    }

    public function test_validacion_falla_por_llaves_foraneas_inexistentes()
    {
        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'asd', 'tor_anio_referencia' => 1900, 'tor_fecha_inicio' => '2013-04-10', 'tor_fecha_fin' => '2013-04-11', 
            'tor_tipo_equipos' => 'profesional', 'tor_numero_equipos' => 2, 'lug_id' => 1, 'ttr_id' => 1,]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');    

        $this->assertTrue($validator->errors()->has('lug_id'),'Se esperaba que exista clave lug_id');
        $this->assertCount(1, $validator->errors()->get('lug_id'),'Se esperaba que exista 1 error en la clave lug_id');        
        $this->assertTrue($validator->errors()->has('ttr_id'),'Se esperaba que exista clave ttr_id');
        $this->assertCount(1, $validator->errors()->get('ttr_id'),'Se esperaba que exista 1 error en la clave ttr_id');

        $this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');        

    }

    public function test_validacion_falla_por_campos_demasiado_cortos()
    {
        $lugar = Factory::create('App\Lugar');
        $tipoTorneo = Factory::create('App\TipoTorneo');

        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'as', 'tor_anio_referencia' => 1900, 'tor_fecha_inicio' => '2013-04-10', 'tor_fecha_fin' => '2013-04-11', 
            'tor_tipo_equipos' => 'profesional', 'tor_numero_equipos' => 1, 'lug_id' => $lugar->lug_id, 'ttr_id' => $tipoTorneo->ttr_id,]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');    

        $this->assertTrue($validator->errors()->has('tor_nombre'),'Se esperaba que exista clave tor_nombre');
        $this->assertCount(1, $validator->errors()->get('tor_nombre'),'Se esperaba que exista 1 error en la clave tor_nombre');        
        $this->assertTrue($validator->errors()->has('tor_numero_equipos'),'Se esperaba que exista clave tor_numero_equipos');
        $this->assertCount(1, $validator->errors()->get('tor_numero_equipos'),'Se esperaba que exista 1 error en la clave tor_numero_equipos');

        $this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

    public function test_validacion_falla_por_formato_de_fechas_dd_mm_yyyy()
    {
        $lugar = Factory::create('App\Lugar');
        $tipoTorneo = Factory::create('App\TipoTorneo');

        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'asd', 'tor_anio_referencia' => 1900, 'tor_fecha_inicio' => '23-10-2013', 'tor_fecha_fin' => '24-10-2013', 
            'tor_tipo_equipos' => 'profesional', 'tor_numero_equipos' => 2, 'lug_id' => $lugar->lug_id, 'ttr_id' => $tipoTorneo->ttr_id,]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');    

        $this->assertTrue($validator->errors()->has('tor_fecha_inicio'),'Se esperaba que exista clave tor_fecha_inicio');
        $this->assertCount(1, $validator->errors()->get('tor_fecha_inicio'),'Se esperaba que exista 1 error en la clave tor_fecha_inicio');        
        $this->assertTrue($validator->errors()->has('tor_fecha_fin'),'Se esperaba que exista clave tor_fecha_fin');
        $this->assertCount(1, $validator->errors()->get('tor_fecha_fin'),'Se esperaba que exista 1 error en la clave tor_fecha_fin');

        $this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

    public function test_validacion_falla_por_formato_de_fechas_mm_dd_yyyy()
    {
        $lugar = Factory::create('App\Lugar');
        $tipoTorneo = Factory::create('App\TipoTorneo');

        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'asd', 'tor_anio_referencia' => 1900, 'tor_fecha_inicio' => '10-23-2013', 'tor_fecha_fin' => '10-24-2013', 
            'tor_tipo_equipos' => 'profesional', 'tor_numero_equipos' => 2, 'lug_id' => $lugar->lug_id, 'ttr_id' => $tipoTorneo->ttr_id,]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');    

        $this->assertTrue($validator->errors()->has('tor_fecha_inicio'),'Se esperaba que exista clave tor_fecha_inicio');
        $this->assertCount(1, $validator->errors()->get('tor_fecha_inicio'),'Se esperaba que exista 1 error en la clave tor_fecha_inicio');        
        $this->assertTrue($validator->errors()->has('tor_fecha_fin'),'Se esperaba que exista clave tor_fecha_fin');
        $this->assertCount(1, $validator->errors()->get('tor_fecha_fin'),'Se esperaba que exista 1 error en la clave tor_fecha_fin');

        $this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

    public function test_validacion_falla_por_tipo_equipos_opcion_errorea()
    {
        $lugar = Factory::create('App\Lugar');
        $tipoTorneo = Factory::create('App\TipoTorneo');

        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'asd', 'tor_anio_referencia' => 1900, 'tor_fecha_inicio' => '2013-10-23', 'tor_fecha_fin' => '2013-10-24', 
            'tor_tipo_equipos' => 'asd', 'tor_numero_equipos' => 2, 'lug_id' => $lugar->lug_id, 'ttr_id' => $tipoTorneo->ttr_id,]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');    

        $this->assertTrue($validator->errors()->has('tor_tipo_equipos'),'Se esperaba que exista clave tor_tipo_equipos');
        $this->assertCount(1, $validator->errors()->get('tor_tipo_equipos'),'Se esperaba que exista 1 error en la clave tor_tipo_equipos');        

        $this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }    

    public function test_validacion_falla_por_letras_en_lugar_de_enteros()
    {
        $lugar = Factory::create('App\Lugar');
        $tipoTorneo = Factory::create('App\TipoTorneo');

        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'asd', 'tor_anio_referencia' => 'x', 'tor_fecha_inicio' => '2013-10-23', 'tor_fecha_fin' => '2013-10-24', 
            'tor_tipo_equipos' => 'profesional', 'tor_numero_equipos' => 'x', 'lug_id' => 'x', 'ttr_id' => 'x',]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');    

        $this->assertTrue($validator->errors()->has('tor_anio_referencia'),'Se esperaba que exista clave tor_anio_referencia');
        $this->assertCount(1, $validator->errors()->get('tor_anio_referencia'),'Se esperaba que exista 1 error en la clave tor_anio_referencia');        
        $this->assertTrue($validator->errors()->has('tor_numero_equipos'),'Se esperaba que exista clave tor_numero_equipos');
        $this->assertCount(2, $validator->errors()->get('tor_numero_equipos'),'Se esperaba que exista 2 error en la clave tor_numero_equipos');        
        $this->assertTrue($validator->errors()->has('lug_id'),'Se esperaba que exista clave lug_id');
        $this->assertCount(1, $validator->errors()->get('lug_id'),'Se esperaba que exista 1 error en la clave lug_id');        
        $this->assertTrue($validator->errors()->has('ttr_id'),'Se esperaba que exista clave ttr_id');
        $this->assertCount(1, $validator->errors()->get('ttr_id'),'Se esperaba que exista 1 error en la clave ttr_id');        

        $this->assertCount(5, $validator->errors()->all(), 'Se esperaban 9 errores de validacion');
    }

    public function test_validacion_exitosa_con_formato_de_fecha_yy_mm_dd()
    {
        $lugar = Factory::create('App\Lugar');
        $tipoTorneo = Factory::create('App\TipoTorneo');

        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'asd', 'tor_anio_referencia' => 1900, 'tor_fecha_inicio' => '13-10-23', 'tor_fecha_fin' => '13-10-24', 
            'tor_tipo_equipos' => 'profesional', 'tor_numero_equipos' => 2, 'lug_id' => $lugar->lug_id, 'ttr_id' => $tipoTorneo->ttr_id,]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        $this->assertTrue($validator->passes(),'Se esperaba que la validadicon sea exitosa.');
    }

    public function test_validacion_exitosa_con_formato_de_fecha_yyyy_mm_dd()
    {
        $lugar = Factory::create('App\Lugar');
        $tipoTorneo = Factory::create('App\TipoTorneo');

        $torneo = Factory::attributesFor(
            'App\Torneo',
            ['tor_nombre' => 'asd', 'tor_anio_referencia' => 1900, 'tor_fecha_inicio' => '2013-10-23', 'tor_fecha_fin' => '2013-10-24', 
            'tor_tipo_equipos' => 'profesional', 'tor_numero_equipos' => 2, 'lug_id' => $lugar->lug_id, 'ttr_id' => $tipoTorneo->ttr_id,]
        );

        $validator = Validator::make($torneo, $this->rules, $this->messages);

        
        $this->assertTrue($validator->passes(),'Se esperaba que la validadicon sea exitosa.');
    }
}