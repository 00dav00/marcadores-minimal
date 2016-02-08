<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\PartidoJugadorTitularRequest;

class PartidoJugadorTitularTest extends TestCase
{	
    use WithoutMiddleware;

    public static function setUpBeforeClass() {
        Artisan::call('migrate:refresh');
    }

    public function setUp() {
    	parent::createApplication();
    }

    private function evalTestRequest($rules, $data, $expectedErrors = null) {
    	$validator = Validator::make($data, $rules);

    	if ( is_null($expectedErrors) ){
    		$this->assertTrue($validator->passes(),'Se esperaba que la validadicon sea exitosa');
    	}
    	else{
    		$this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

    		foreach ($expectedErrors as $error) {
    			$this->assertTrue($validator->errors()->has($error),'Se esperaba que exista la clave '.$error);
				$this->assertCount(1, $validator->errors()->get($error),'Se esperaba que exista 1 error en la clave '.$error);
    		}

			$this->assertCount(
				count($expectedErrors), $validator->errors()->all(), 
				'Se esperaban '.count($expectedErrors).' errores de validacion'
			);
    	}
    }
    
    public function test_validacion_falla_por_campos_vacios() {
    	$this->evalTestRequest(
			PartidoJugadorTitularRequest::$rules,
			[
				'par_id' => null, 'jug_id' => null, 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 
				'pju_amarilla' => null, 'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => null, 
				'pju_juvenil' => null
			],
			['par_id', 'jug_id']
		);
    }

    public function test_validacion_falla_por_campos_de_tipo_incorrecto() {
    	$this->evalTestRequest(
			PartidoJugadorTitularRequest::$rules,
			[
				'par_id' => 'X', 'jug_id' => 'X', 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 
				'pju_amarilla' => null, 'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => 'X', 
				'pju_juvenil' => 'X'
			],
			['par_id', 'jug_id', 'pju_numero_camiseta', 'pju_juvenil']
		);
    }

    public function test_validacion_falla_por_llaves_foraneas_inexistentes() {
    	$this->evalTestRequest(
			PartidoJugadorTitularRequest::$rules,
			['par_id' => 1, 'jug_id' => 1, 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 'pju_amarilla' => null,
			'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => 1, 'pju_juvenil' => true],
			['par_id', 'jug_id']
		);
    }

    public function test_validacion_exitosa() {
    	$jugador = factory(App\Jugador::class)->create();
    	$partido = factory(App\Partido::class)->create();
    	$this->evalTestRequest(
			PartidoJugadorTitularRequest::$rules,
			[
				'par_id' => $partido->par_id, 'jug_id' => $jugador->jug_id, 'pju_minuto_ingreso' => null, 'pju_reemplazo_de' => null, 
				'pju_amarilla' => null, 'pju_doble_amarilla' => null, 'pju_roja' => null, 'pju_numero_camiseta' => 1, 'pju_juvenil' => true
			]
		);
    }

}