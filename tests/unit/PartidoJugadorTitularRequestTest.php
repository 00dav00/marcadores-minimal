<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\PartidoJugadorTitularRequest;

class PartidoJugadorTitularTest extends TestCase
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
        $this->rules = PartidoJugadorTitularRequest::$rules;
    	$this->messages = PartidoJugadorTitularRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
		$jugadorPartido = [
			'par_id' => null, 'jug_id' => null, 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 
			'pju_amarilla' => null, 'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => null, 'pju_juvenil' => null
		];
		$validator = Validator::make($jugadorPartido, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('par_id'),'Se esperaba que exista la clave par_id');
		$this->assertCount(1, $validator->errors()->get('par_id'),'Se esperaba que exista 1 error en la clave par_id');
		$this->assertTrue($validator->errors()->has('jug_id'),'Se esperaba que exista la clave jug_id');
		$this->assertCount(1, $validator->errors()->get('jug_id'),'Se esperaba que exista 1 error en la clave jug_id');

		$this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }

    public function test_validacion_falla_por_campos_de_tipo_incorrecto()
    {
		$jugadorPartido =	[
			'par_id' => 'X', 'jug_id' => 'X', 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 
			'pju_amarilla' => null, 'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => 'X', 'pju_juvenil' => 'X'
		];
		$validator = Validator::make($jugadorPartido, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('par_id'),'Se esperaba que exista la clave par_id');
		$this->assertCount(1, $validator->errors()->get('par_id'),'Se esperaba que exista 1 error en la clave par_id');
		$this->assertTrue($validator->errors()->has('jug_id'),'Se esperaba que exista la clave jug_id');
		$this->assertCount(1, $validator->errors()->get('jug_id'),'Se esperaba que exista 1 error en la clave jug_id');
		$this->assertTrue($validator->errors()->has('pju_numero_camiseta'),'Se esperaba que exista la clave pju_numero_camiseta');
		$this->assertCount(1, $validator->errors()->get('pju_numero_camiseta'),'Se esperaba que exista 1 error en la clave pju_numero_camiseta');
		$this->assertTrue($validator->errors()->has('pju_juvenil'),'Se esperaba que exista la clave pju_juvenil');
		$this->assertCount(1, $validator->errors()->get('pju_juvenil'),'Se esperaba que exista 1 error en la clave pju_juvenil');
		$numeroErrores = 4;
		$this->assertCount($numeroErrores, $validator->errors()->all(), 'Se esperaban '.$numeroErrores.' errores de validacion');
    }

    public function test_validacion_falla_por_llaves_foraneas_inexistentes()
    {
		$jugadorPartido =[
			'par_id' => 1, 'jug_id' => 1, 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 
			'pju_amarilla' => null, 'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => 1, 'pju_juvenil' => true
		];
		$validator = Validator::make($jugadorPartido, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
		$this->assertTrue($validator->errors()->has('par_id'),'Se esperaba que exista la clave par_id');
		$this->assertCount(1, $validator->errors()->get('par_id'),'Se esperaba que exista 1 error en la clave par_id');
		$this->assertTrue($validator->errors()->has('jug_id'),'Se esperaba que exista la clave jug_id');
		$this->assertCount(1, $validator->errors()->get('jug_id'),'Se esperaba que exista 1 error en la clave jug_id');
		$numeroErrores = 2;
		$this->assertCount($numeroErrores, $validator->errors()->all(), 'Se esperaban '.$numeroErrores.' errores de validacion');
    }

    public function test_validacion_exitosa()
    {
    	$jugador = factory(App\Jugador::class)->create();
    	$partido = factory(App\Partido::class)->create();
		$jugadorPartido =	[
			'par_id' => $partido->par_id, 'jug_id' => $jugador->jug_id, 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 
			'pju_amarilla' => null, 'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => 1, 'pju_juvenil' => true
		];

		$validator = Validator::make($jugadorPartido, $this->rules, $this->messages);
		
		$this->assertTrue($validator->passes(),'Se esperaba que la validadicon sea exitosa');
    }

}