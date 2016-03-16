<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\AmonestacionRequest;

class AmonestacionTest extends TestCase
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
			AmonestacionRequest::$rules,
			['par_id' => null, 'jug_id' => null, 'eqp_id' => null, 'amn_tipo' => null, 'amn_minuto' => null],
			['par_id', 'jug_id', 'eqp_id', 'amn_tipo', 'amn_minuto']
		);
    }

    public function test_validacion_falla_por_campos_de_tipo_incorrecto() {
        $this->evalTestRequest(
            AmonestacionRequest::$rules,
            ['par_id' => 'x', 'jug_id' => 'x', 'eqp_id' => 'x', 'amn_tipo' => 'x', 'amn_minuto' => 'x'],
            ['par_id', 'jug_id', 'eqp_id', 'amn_tipo', 'amn_minuto']
        );
    }

    public function test_validacion_falla_por_llaves_foraneas_inexistentes() {
        $this->evalTestRequest(
            AmonestacionRequest::$rules,
            ['par_id' => 1, 'jug_id' => 1, 'eqp_id' => 1, 'amn_tipo' => 'roja', 'amn_minuto' => 1],
            ['par_id', 'jug_id', 'eqp_id']
        );
    }

    public function test_validacion_exitosa() {
        $jugador = factory(App\Jugador::class)->create();
        $partido = factory(App\Partido::class)->create();
        
        $this->evalTestRequest(
            AmonestacionRequest::$rules,
            ['par_id' => $partido->par_id, 'jug_id' => $jugador->jug_id, 'eqp_id' => $partido->par_eqp_local, 'amn_tipo' => 'roja', 'amn_minuto' => 1]
        );
    }
}