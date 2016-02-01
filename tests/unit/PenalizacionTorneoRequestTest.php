<?php

use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\PenalizacionTorneoRequest;

class PenalizacionTorneoRequestTest extends TestCase
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
        $this->rules = PenalizacionTorneoRequest::$rules;
    	$this->messages = PenalizacionTorneoRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
        $penalizacion = Factory::attributesFor(
            'App\PenalizacionTorneo',
            ['eqp_id' => null,'fas_id' => null,'ptr_puntos' => null,'ptr_motivo' => '']
        );
        $validator = Validator::make($penalizacion, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('eqp_id'),'Se esperaba que exista la clave eqp_id');
        $this->assertCount(1, $validator->errors()->get('eqp_id'),'Se esperaba que exista 1 error en la clave eqp_id');
        $this->assertTrue($validator->errors()->has('fas_id'),'Se esperaba que exista la clave fas_id');
        $this->assertCount(1, $validator->errors()->get('fas_id'),'Se esperaba que exista 1 error en la clave fas_id');
        $this->assertTrue($validator->errors()->has('ptr_puntos'),'Se esperaba que exista la clave ptr_puntos');
        $this->assertCount(1, $validator->errors()->get('ptr_puntos'),'Se esperaba que exista 1 error en la clave ptr_puntos');

        $this->assertCount(3, $validator->errors()->all(), 'Se esperaban 3 errores de validacion');
    }

    public function test_validacion_falla_por_campos_de_tipo_incorrecto()
    {
        $penalizacion = Factory::attributesFor(
            'App\PenalizacionTorneo',
            ['eqp_id' => 'x','fas_id' => 'x','ptr_puntos' => 'x','ptr_motivo' => '']
        );
        $validator = Validator::make($penalizacion, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('eqp_id'),'Se esperaba que exista la clave eqp_id');
        $this->assertCount(1, $validator->errors()->get('eqp_id'),'Se esperaba que exista 1 error en la clave eqp_id');
        $this->assertTrue($validator->errors()->has('fas_id'),'Se esperaba que exista la clave fas_id');
        $this->assertCount(1, $validator->errors()->get('fas_id'),'Se esperaba que exista 1 error en la clave fas_id');
        $this->assertTrue($validator->errors()->has('ptr_puntos'),'Se esperaba que exista la clave ptr_puntos');
        $this->assertCount(1, $validator->errors()->get('ptr_puntos'),'Se esperaba que exista 1 error en la clave ptr_puntos');

        $this->assertCount(3, $validator->errors()->all(), 'Se esperaban 3 errores de validacion');
    }

    public function test_validacion_falla_por_llaves_foraneas_no_existen()
    {        
        $penalizacion = Factory::attributesFor(
            'App\PenalizacionTorneo',
            ['eqp_id' => 1,'fas_id' => 1,'ptr_puntos' => 1,'ptr_motivo' => '']
        );
        $validator = Validator::make($penalizacion, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('eqp_id'),'Se esperaba que exista la clave eqp_id');
        $this->assertCount(1, $validator->errors()->get('eqp_id'),'Se esperaba que exista 1 error en la clave eqp_id');
        $this->assertTrue($validator->errors()->has('fas_id'),'Se esperaba que exista la clave fas_id');
        $this->assertCount(1, $validator->errors()->get('fas_id'),'Se esperaba que exista 1 error en la clave fas_id');

        $this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    }


    public function test_validacion_falla_por_campos_demasiado_cortos()
    {
        $equipo = factory(App\Equipo::class)->create();
        $fase = factory(App\Fase::class)->create();

         $penalizacion = Factory::attributesFor(
            'App\PenalizacionTorneo',
            ['eqp_id' => $equipo->eqp_id,'fas_id' => $fase->fas_id,'ptr_puntos' => 1,'ptr_motivo' => 'as']
        );
        $validator = Validator::make($penalizacion, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');
        $this->assertTrue($validator->errors()->has('ptr_motivo'),'Se esperaba que exista la clave ptr_motivo');
        $this->assertCount(1, $validator->errors()->get('ptr_motivo'),'Se esperaba que exista 1 error en la clave ptr_motivo');

        $this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_exitosa()
    {
        $equipo = factory(App\Equipo::class)->create();
        $fase = factory(App\Fase::class)->create();

         $penalizacion = Factory::attributesFor(
            'App\PenalizacionTorneo',
            ['eqp_id' => $equipo->eqp_id,'fas_id' => $fase->fas_id,'ptr_puntos' => 1,'ptr_motivo' => 'asd']
        );
        $validator = Validator::make($penalizacion, $this->rules, $this->messages);
        
        $this->assertTrue($validator->passes(),'Se esperaba que la validadicon sea exitosa.');
    }

}