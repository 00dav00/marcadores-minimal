<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\PartidoGolRequest;

class PartidoGolRequestTest extends TestCase
{	
    use WithoutMiddleware;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
    }

    public function setUp()
    {
    	parent::createApplication();
    }

    private function evalTestRequest($rules, $data, $expectedErrors = null){
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
			PartidoGolRequest::$rules,
			['gol_minuto'=>null,'gol_jugada'=>null,'gol_ejecucion'=>null,'gol_autor'=>null,'gol_asistencia'=>null,'par_id'=>null,'eqp_id'=>null],
			['gol_minuto','gol_autor','par_id','eqp_id']
		);
    }

	public function test_validacion_falla_por_campos_de_tipo_inadecuado()  {
		$this->evalTestRequest(
			PartidoGolRequest::$rules,
			['gol_minuto'=>'x', 'gol_jugada'=>null, 'gol_ejecucion'=>null, 'gol_autor'=>'x', 'gol_asistencia'=>'x','par_id'=>'x','eqp_id'=>'x'],
			['gol_minuto','gol_autor','gol_asistencia','par_id','eqp_id']
		);
    }

	public function test_validacion_falla_por_llaves_foraneas_inexistentes() {
		$this->evalTestRequest(
			PartidoGolRequest::$rules,
			['gol_minuto'=>1, 'gol_jugada'=>null, 'gol_ejecucion'=>null, 'gol_autor'=>10, 'gol_asistencia'=>10,'par_id'=>10,'eqp_id'=>10],
			['gol_autor','gol_asistencia','par_id','eqp_id']
		);
    }    

    public function test_validacion_exitosa() {
    	$jugador = factory(App\Jugador::class)->create();
    	$partido = factory(App\Partido::class)->create();
    	$equipo = factory(App\Equipo::class)->create();
		$this->evalTestRequest(
			PartidoGolRequest::$rules,
			['gol_minuto'=>1, 'gol_jugada'=>null, 'gol_ejecucion'=>null, 
			'gol_autor'=>$jugador->jug_id, 'gol_asistencia'=>$jugador->jug_id,'par_id'=>$partido->par_id,'eqp_id'=>$equipo->eqp_id]
		);
    }

    public function test_validacion_falla_por_valores_fuera_de_lista() {
    	$jugador = factory(App\Jugador::class)->create();
    	$partido = factory(App\Partido::class)->create();
    	$equipo = factory(App\Equipo::class)->create();
		$this->evalTestRequest(
			PartidoGolRequest::$rules,
			['gol_minuto'=>1, 'gol_jugada'=>'x', 'gol_ejecucion'=>'x', 
			'gol_autor'=>$jugador->jug_id, 'gol_asistencia'=>$jugador->jug_id, 'par_id'=>$partido->par_id, 'eqp_id'=>$equipo->eqp_id],
			['gol_jugada','gol_ejecucion']
		);
    }

    public function test_validacion_exitosa_con_campos_completos() {
    	$jugador = factory(App\Jugador::class)->create();
    	$partido = factory(App\Partido::class)->create();
    	$equipo = factory(App\Equipo::class)->create();
		$this->evalTestRequest(
			PartidoGolRequest::$rules,
			['gol_minuto'=>1, 'gol_auto'=>true, 'gol_jugada'=>'contra', 'gol_ejecucion'=>'cabeza', 
			'gol_autor'=>$jugador->jug_id, 'gol_asistencia'=>$jugador->jug_id, 'par_id'=>$partido->par_id, 'eqp_id'=>$equipo->eqp_id]
		);
    }
}