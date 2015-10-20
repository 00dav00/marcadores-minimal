<?php

use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\TipoFaseRequest;

class TipoFaseRequestTest extends TestCase
{		
	use DatabaseTransactions;
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
        $this->rules = TipoFaseRequest::$rules;
    	$this->messages = TipoFaseRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
    	$tipoFase = Factory::attributesFor(
			'App\TipoFase',['tfa_nombre' => '', 'tfa_descripcion' => '']
		);
		$validator = Validator::make($tipoFase, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('tfa_nombre'),'Se esperaba que exista la clave tfa_nombre');
		$this->assertCount(1, $validator->errors()->get('tfa_nombre'),'Se esperaba que exista 1 error en la clave tfa_nombre');

		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_falla_por_campos_demasiado_cortos()
    {
    	$tipoFase = Factory::attributesFor(
			'App\TipoFase',['tfa_nombre' => 'as', 'tfa_descripcion' => 'as']
		);
		$validator = Validator::make($tipoFase, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('tfa_nombre'),'Se esperaba que exista la clave tfa_nombre');
		$this->assertCount(1, $validator->errors()->get('tfa_nombre'),'Se esperaba que exista 1 error en la clave tfa_nombre');
		$this->assertTrue($validator->errors()->has('tfa_descripcion'),'Se esperaba que exista la clave tfa_descripcion');
		$this->assertCount(1, $validator->errors()->get('tfa_descripcion'),'Se esperaba que exista 1 error en la clave tfa_descripcion');

		$this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');	
    }
}