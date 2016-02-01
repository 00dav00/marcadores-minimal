<?php

use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Requests\AuspicianteRequest;

class AuspicianteRequestTest extends TestCase
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
        $this->rules = AuspicianteRequest::$rules;
    	$this->messages = AuspicianteRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {

		$auspiciante = Factory::attributesFor(
			'App\Auspiciante',
			[
                'aus_nombre' => '',
                'aus_sitioweb' => '',
                'aus_imagen' => ''
            ]
		);

		$validator = Validator::make($auspiciante, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		
		$this->assertTrue($validator->errors()->has('aus_nombre'),'Se esperaba que exista la clave aus_nombre');
		$this->assertCount(1, $validator->errors()->get('aus_nombre'),'Se esperaba que exista 1 error en la clave aus_nombre');
		
		$this->assertTrue($validator->errors()->has('aus_imagen'),'Se esperaba que exista la clave aus_imagen');
		$this->assertCount(1, $validator->errors()->get('aus_imagen'),'Se esperaba que exista 1 error en la clave aus_imagen');
		
		$this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

    public function test_validacion_falla_por_campos_demasiado_cortos()
    {

		$auspiciante = Factory::attributesFor(
			'App\Auspiciante',
			[
                'aus_nombre' => 'as',
                'aus_sitioweb' => '',
                'aus_imagen' => 'as'
            ]
		);

		$validator = Validator::make($auspiciante, AuspicianteRequest::$rules, AuspicianteRequest::$messages);

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validacion.');
		
		$this->assertTrue($validator->errors()->has('aus_nombre'),'Se esperaba que exista la clave aus_nombre');
		$this->assertCount(1, $validator->errors()->get('aus_nombre'),'Se esperaba que exista 1 error en la clave aus_nombre');

		$this->assertCount(3, $validator->errors()->all(), 'Se esperaban 1 error de validacion');
    }

    public function test_validacion_falla_por_formato_sitio_web_abc_dot_com()
    {
		$auspiciante = Factory::attributesFor(
			'App\Auspiciante',
			[
                'aus_nombre' => 'asd',
                'aus_sitioweb' => 'asd',
                'aus_imagen' => ''
            ]
		);

		$validator = Validator::make($auspiciante, AuspicianteRequest::$rules, AuspicianteRequest::$messages);

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

		$this->assertTrue($validator->errors()->has('aus_sitioweb'),'Se esperaba error por formato del campo aus_sitioweb');
		$this->assertCount(1, $validator->errors()->get('aus_sitioweb'),'Se esperaba que exista 1 error en la clave aus_sitioweb');

		$this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

    public function test_validacion_exitoso_con_formato_sitio_web_http_abc_dot_com()
    {
		$auspiciante = Factory::attributesFor(
			'App\Auspiciante',
			[
                'aus_nombre' => 'asd',
                'aus_sitioweb' => 'http://asd.com',
                'aus_imagen' => ''
            ]
		);

		$validator = Validator::make($auspiciante, AuspicianteRequest::$rules, AuspicianteRequest::$messages);

		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 error de validacion');
    }
}