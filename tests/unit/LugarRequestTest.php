<?php

use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\LugarRequest;

class LugarRequestTest extends TestCase
{	
    use WithoutMiddleware;

    private $rules;
    private $messages;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
    }

    public function setUp()
    {
    	parent::createApplication();
        $this->rules = LugarRequest::$rules;
    	$this->messages = LugarRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
    	$lugar = Factory::attributesFor(
			'App\Lugar', 
            ['lug_abreviatura' => null, 'lug_nombre' => null, 'lug_tipo' => null, 'parent_lug_id' => null]
		);
		$validator = Validator::make($lugar, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('lug_abreviatura'),'Se esperaba que exista la clave lug_abreviatura');
		$this->assertCount(1, $validator->errors()->get('lug_abreviatura'),'Se esperaba que exista 1 error en la clave lug_abreviatura');
		$this->assertTrue($validator->errors()->has('lug_nombre'),'Se esperaba que exista la clave lug_nombre');
		$this->assertCount(1, $validator->errors()->get('lug_nombre'),'Se esperaba que exista 1 error en la clave lug_nombre');
        $this->assertTrue($validator->errors()->has('lug_tipo'),'Se esperaba que exista la clave lug_tipo');
        $this->assertCount(1, $validator->errors()->get('lug_tipo'),'Se esperaba que exista 1 error en la clave lug_tipo');

		$this->assertCount(3, $validator->errors()->all(), 'Se esperaban 3 errores de validacion');
    }

    public function test_validacion_falla_por_campos_demasiado_cortos()
    {
        $lugar = Factory::attributesFor(
            'App\Lugar', 
            ['lug_abreviatura' => 'a', 'lug_nombre' => 'a', 'lug_tipo' => 'pais', 'parent_lug_id' => null]
        );
        $validator = Validator::make($lugar, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('lug_abreviatura'),'Se esperaba que exista la clave lug_abreviatura');
        $this->assertCount(1, $validator->errors()->get('lug_abreviatura'),'Se esperaba que exista 1 error en la clave lug_abreviatura');
        $this->assertTrue($validator->errors()->has('lug_nombre'),'Se esperaba que exista la clave lug_nombre');
        $this->assertCount(1, $validator->errors()->get('lug_nombre'),'Se esperaba que exista 1 error en la clave lug_nombre');

        $this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

    public function test_validacion_falla_por_campo_distinto_a_opciones_validas()
    {
        $lugar = Factory::attributesFor(
            'App\Lugar', 
            ['lug_abreviatura' => 'asd', 'lug_nombre' => 'asd', 'lug_tipo' => 'paises', 'parent_lug_id' => null]
        );
        $validator = Validator::make($lugar, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('lug_tipo'),'Se esperaba que exista la clave lug_tipo');
        $this->assertCount(1, $validator->errors()->get('lug_tipo'),'Se esperaba que exista 1 error en la clave lug_tipo');

        $this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_falla_por_formato_clave_letras()
    {
        $lugar = Factory::attributesFor(
            'App\Lugar', 
            ['lug_abreviatura' => 'asd', 'lug_nombre' => 'asd', 'lug_tipo' => 'pais', 'parent_lug_id' => 'a']
        );
        $validator = Validator::make($lugar, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('parent_lug_id'),'Se esperaba que exista la clave parent_lug_id');
        $this->assertCount(1, $validator->errors()->get('parent_lug_id'),'Se esperaba que exista 1 error en la clave parent_lug_id');

        $this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_falla_por_clave_foranea_inexistente()
    {
        $lugar = Factory::attributesFor(
            'App\Lugar', 
            ['lug_abreviatura' => 'asd', 'lug_nombre' => 'asd', 'lug_tipo' => 'pais', 'parent_lug_id' => 1]
        );
        $validator = Validator::make($lugar, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('parent_lug_id'),'Se esperaba que exista la clave parent_lug_id');
        $this->assertCount(1, $validator->errors()->get('parent_lug_id'),'Se esperaba que exista 1 error en la clave parent_lug_id');

        $this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_exitosa_sin_clave_foranea_lugar()
    {
        $lugar = Factory::attributesFor(
            'App\Lugar', 
            ['lug_abreviatura' => 'asd', 'lug_nombre' => 'asd', 'lug_tipo' => 'pais', 'parent_lug_id' => null]
        );
        $validator = Validator::make($lugar, $this->rules, $this->messages);
        
        $this->assertTrue($validator->passes(),'Se esperaba que falle la validadicon.');
    }

    public function test_validacion_exitosa_con_clave_foranea_lugar()
    {
        $padre = Factory::create('App\Lugar');
        $lugar = Factory::attributesFor(
            'App\Lugar', 
            ['lug_abreviatura' => 'asd', 'lug_nombre' => 'asd', 'lug_tipo' => 'pais', 'parent_lug_id' => $padre->lug_id]
        );
        $validator = Validator::make($lugar, $this->rules, $this->messages);
        
        $this->assertTrue($validator->passes(),'Se esperaba que falle la validadicon.');
    }

}