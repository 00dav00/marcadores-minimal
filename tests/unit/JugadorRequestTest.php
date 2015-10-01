<?php


use Way\Tests\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\JugadorRequest;

class JugadorRequestTest extends TestCase
{	
	use DatabaseTransactions;
    use WithoutMiddleware;

    private $rules;// = JugadorRequest::$rules;
    private $messages;// = JugadorRequest::$messages;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
    }

    public function setUp()
    {
    	parent::createApplication();   	    
        $this->rules = JugadorRequest::$rules;
    	$this->messages = JugadorRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
    	$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => '','jug_nombre' => '','jug_apodo' => '','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);
		$validator = Validator::make($jugador, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_apellido'),'Se esperaba que exista la clave jug_apellido');
		$this->assertCount(1, $validator->errors()->get('jug_apellido'),'Se esperaba que exista 1 error en la clave jug_apellido');
		$this->assertTrue($validator->errors()->has('jug_nombre'),'Se esperaba que exista la clave jug_nombre');
		$this->assertCount(1, $validator->errors()->get('jug_nombre'),'Se esperaba que exista 1 error en la clave jug_nombre');
		// $this->assertEquals(JugadorRequest::$messages["jug_apellido.required"], $validator->errors()->first('jug_apellido'));
		// $this->assertEquals(JugadorRequest::$messages["jug_nombre.required"], $validator->errors()->first('jug_nombre'));
		$this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

	public function test_validacion_falla_por_campos_demasiado_cortos()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'as','jug_nombre' => 'as','jug_apodo' => 'as','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_apellido'),'Se esperaba que exista la clave jug_apellido');
		$this->assertCount(1, $validator->errors()->get('jug_apellido'),'Se esperaba que exista 1 error en la clave jug_apellido');
		$this->assertTrue($validator->errors()->has('jug_nombre'),'Se esperaba que exista la clave jug_nombre');
		$this->assertCount(1, $validator->errors()->get('jug_nombre'),'Se esperaba que exista 1 error en la clave jug_nombre');
		$this->assertTrue($validator->errors()->has('jug_apodo'),'Se esperaba que exista la clave jug_apodo');
		$this->assertCount(1, $validator->errors()->get('jug_apodo'),'Se esperaba que exista 1 error en la clave jug_apodo');
		$this->assertCount(3, $validator->errors()->all(), 'Se esperaban 3 errores de validacion');
    }

    public function test_validacion_falla_por_formato_de_fecha_nacimiento_dd_mm_yyyy()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '15-09-2015',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_fecha_nacimiento'),'Se esperaba error por formato del campo jug_fecha_nacimiento');
		$this->assertCount(1, $validator->errors()->get('jug_fecha_nacimiento'),'Se esperaba que exista 1 error en la clave jug_fecha_nacimiento');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }    

    public function test_validacion_falla_por_formato_de_fecha_nacimiento_mm_dd_yyyy()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '09-15-2015',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_fecha_nacimiento'),'Se esperaba error por formato del campo jug_fecha_nacimiento');
		$this->assertCount(1, $validator->errors()->get('jug_fecha_nacimiento'),'Se esperaba que exista 1 error en la clave jug_fecha_nacimiento');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_exitosa_con_formato_de_fecha_nacimiento_yy_mm_dd()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '15-09-23',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertTrue($validator->passes(),'Se esperaba que la validadicon de la fecha de nacimiento sea exitosa.');
    }

    public function test_validacion_exitosa_con_formato_de_fecha_nacimiento_yyyy_mm_dd()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '2015-09-23',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertTrue($validator->passes(),'Se esperaba que la validadicon de la fecha de nacimiento sea exitosa.');
    }

    public function test_validacion_falla_por_formato_altura_letras()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => 'abc','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_altura'),'Se esperaba error por formato del campo jug_altura');
		$this->assertCount(1, $validator->errors()->get('jug_altura'),'Se esperaba que exista 1 error en la clave jug_altura');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_falla_por_formato_altura_decimal()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '150.7','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_altura'),'Se esperaba error por formato del campo jug_altura');
		$this->assertCount(1, $validator->errors()->get('jug_altura'),'Se esperaba que exista 1 error en la clave jug_altura');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_exitosa_con_formato_altura_entero()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '170','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertTrue($validator->passes(),'Se esperaba que la validadicon del formato de altura sea exitosa.');
		// $this->assertTrue($validator->errors()->has('jug_altura'),'Se esperaba error por formato del campo jug_altura');
		// $this->assertCount(1, $validator->errors()->get('jug_altura'),'Se esperaba que exista 1 error en la clave jug_altura');
		// $this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_falla_por_formato_sitio_web_abedf()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => 'comcomcomcom','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_sitioweb'),'Se esperaba error por formato del campo jug_sitioweb');
		$this->assertCount(1, $validator->errors()->get('jug_sitioweb'),'Se esperaba que exista 1 error en la clave jug_sitioweb');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

	public function test_validacion_falla_por_formato_sitio_web_abc_dot_com()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => 'com.com','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_sitioweb'),'Se esperaba error por formato del campo jug_sitioweb');
		$this->assertCount(1, $validator->errors()->get('jug_sitioweb'),'Se esperaba que exista 1 error en la clave jug_sitioweb');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_exitoso_con_formato_sitio_web_http_abc_dot_com()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => 'http://com.com','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertTrue($validator->passes(),'Se esperaba que la validacion del formato del sitio web con http sea exitosa.');
    }

    public function test_validacion_exitoso_con_formato_sitio_web_https_abc_dot_com()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => 'https://com.com','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertTrue($validator->passes(),'Se esperaba que la validacion del formato del sitio web con https sea exitosa.');
    }

	public function test_validacion_falla_por_formato_nacionalidad_letras()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => 'o',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_nacionalidad'),'Se esperaba error por formato del campo jug_nacionalidad');
		$this->assertCount(1, $validator->errors()->get('jug_nacionalidad'),'Se esperaba que exista 1 error en la clave jug_nacionalidad');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }    

    public function test_validacion_falla_por_formato_nacionalidad_llave_foranea_no_existe()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '1',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('jug_nacionalidad'),'Se esperaba error por inexistencia de clave jug_nacionalidad en tabla lugares');
		$this->assertCount(1, $validator->errors()->get('jug_nacionalidad'),'Se esperaba que exista 1 error en la clave jug_nacionalidad');
		$this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_exitosa_de_nacionalidad()
    {
    	Factory::create('App\Lugar');
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'asp','jug_nombre' => 'asp','jug_apodo' => 'asp','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '1',]
		);  
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		// var_dump($validator->errors());

		$this->assertTrue($validator->passes(),'Se esperaba que falle la validadicon.');
    }

}