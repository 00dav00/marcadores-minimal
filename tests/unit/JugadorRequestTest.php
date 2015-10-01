<?php

use App\Http\Requests\JugadorRequest;
// use App\Jugador;

use Way\Tests\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class JugadorRequestTest extends TestCase
{
	// use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_validacion_falla_por_campos_vacios()
    {
    	$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => '','jug_nombre' => '','jug_apodo' => '','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);
		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		
		$this->assertFalse($validator->passes());
		$this->assertCount(2, $validator->errors());
		$this->arrayHasKey('jug_apellido.minrequired');
		$this->arrayHasKey('jug_nombre.required');
		// $this->assertEquals(JugadorRequest::$messages["jug_apellido.required"], $validator->errors()->first('jug_apellido'));
		// $this->assertEquals(JugadorRequest::$messages["jug_nombre.required"], $validator->errors()->first('jug_nombre'));
    }

	public function test_validacion_falla_por_campos_demasiado_cortos()
    {
		$jugador = Factory::attributesFor(
			'App\Jugador',
			['jug_id' => '','jug_apellido' => 'as','jug_nombre' => 'as','jug_apodo' => 'as','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  

		$validator = Validator::make($jugador, JugadorRequest::$rules, JugadorRequest::$messages);
		$this->assertFalse($validator->passes());
		$this->arrayHasKey('jug_apellido.min');
		$this->arrayHasKey('jug_nombre.min');
		$this->arrayHasKey('jug_apodo.min');
		$this->assertCount(3, $validator->errors());
    }    
}