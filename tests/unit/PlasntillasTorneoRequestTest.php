<?php


use Way\Tests\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Http\Requests\PlantillaTorneoRequest;

class PlantillaTorneoRequestTest extends TestCase
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
        $this->rules = PlantillaTorneoRequest::$rules;
    	$this->messages = PlantillaTorneoRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
        $plantillaTorneo = Factory::attributesFor(
            'App\PlantillaTorneo', ['plt_numero_camiseta' => '', 'eqp_id' => '', 'jug_id' => '', 'tor_id' => '']
        );

        $validator = Validator::make($plantillaTorneo, $this->rules, $this->messages);
        
        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

        $this->assertTrue($validator->errors()->has('plt_numero_camiseta'),'Se esperaba que exista la clave plt_numero_camiseta');
        $this->assertCount(1, $validator->errors()->get('plt_numero_camiseta'),'Se esperaba que exista 1 error en la clave plt_numero_camiseta');
        
        $this->assertTrue($validator->errors()->has('eqp_id'),'Se esperaba que exista la clave eqp_id');
        $this->assertCount(1, $validator->errors()->get('eqp_id'),'Se esperaba que exista 1 error en la clave eqp_id');

        $this->assertTrue($validator->errors()->has('jug_id'),'Se esperaba que exista la clave jug_id');
        $this->assertCount(1, $validator->errors()->get('jug_id'),'Se esperaba que exista 1 error en la clave jug_id');

        $this->assertTrue($validator->errors()->has('tor_id'),'Se esperaba que exista la clave tor_id');
        $this->assertCount(1, $validator->errors()->get('tor_id'),'Se esperaba que exista 1 error en la clave tor_id');
        
        $this->assertCount(4, $validator->errors()->all(), 'Se esperaban 4 errores de validacion');
    }

    public function test_validacion_falla_por_campos_de_tipo_equivocado()
    {
        $plantillaTorneo = Factory::attributesFor(
            'App\PlantillaTorneo', ['plt_numero_camiseta' => 'x', 'eqp_id' => 'x', 'jug_id' => 'x', 'tor_id' => 'x']
        );

        $validator = Validator::make($plantillaTorneo, $this->rules, $this->messages);

        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

        $this->assertTrue($validator->errors()->has('plt_numero_camiseta'),'Se esperaba que exista la clave plt_numero_camiseta');
        $this->assertCount(1, $validator->errors()->get('plt_numero_camiseta'),'Se esperaba que exista 1 error en la clave plt_numero_camiseta');

        $this->assertTrue($validator->errors()->has('eqp_id'),'Se esperaba que exista la clave eqp_id');
        $this->assertCount(1, $validator->errors()->get('eqp_id'),'Se esperaba que exista 1 error en la clave eqp_id');

        $this->assertTrue($validator->errors()->has('jug_id'),'Se esperaba que exista la clave jug_id');
        $this->assertCount(1, $validator->errors()->get('jug_id'),'Se esperaba que exista 1 error en la clave jug_id');

        $this->assertTrue($validator->errors()->has('tor_id'),'Se esperaba que exista la clave tor_id');
        $this->assertCount(1, $validator->errors()->get('tor_id'),'Se esperaba que exista 1 error en la clave tor_id');


        $this->assertCount(4, $validator->errors()->all(), 'Se esperaban 4 errores de validacion');
    }

    public function test_validacion_falla_porque_llaves_foraneas_no_existen()
    {
        $plantillaTorneo = Factory::attributesFor(
            'App\PlantillaTorneo', ['plt_numero_camiseta' => '1', 'eqp_id' => '1', 'jug_id' => '1', 'tor_id' => '1']
        );

        $validator = Validator::make($plantillaTorneo, $this->rules, $this->messages);

        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

        $this->assertTrue($validator->errors()->has('eqp_id'),'Se esperaba que exista la clave eqp_id');
        $this->assertCount(1, $validator->errors()->get('eqp_id'),'Se esperaba que exista 1 error en la clave eqp_id');

        $this->assertTrue($validator->errors()->has('jug_id'),'Se esperaba que exista la clave jug_id');
        $this->assertCount(1, $validator->errors()->get('jug_id'),'Se esperaba que exista 1 error en la clave jug_id');

        $this->assertTrue($validator->errors()->has('tor_id'),'Se esperaba que exista la clave tor_id');
        $this->assertCount(1, $validator->errors()->get('tor_id'),'Se esperaba que exista 1 error en la clave tor_id');


        $this->assertCount(3, $validator->errors()->all(), 'Se esperaban 3 errores de validacion');
    }

    public function test_validacion_exitosa()
    {
        Factory::create('App\Lugar',['lug_id' => 1]);
        Factory::create('App\TipoTorneo',['ttr_id' => 1]);

        Factory::create('App\Equipo',['eqp_id' => 1, 'lug_id' => 1]);
        Factory::create('App\Jugador',['jug_id' => 1, 'jug_nacionalidad' => 1]);
        Factory::create('App\Torneo',['tor_id' => 1, 'lug_id' => 1, 'ttr_id' => 1]); 

        $plantillaTorneo = Factory::attributesFor(
            'App\PlantillaTorneo', ['plt_numero_camiseta' => 1, 'eqp_id' => 1, 'jug_id' => 1, 'tor_id' => 1]
        );
        
        $validator = Validator::make($plantillaTorneo, $this->rules, $this->messages);

        $this->assertTrue($validator->passes(),'Se esperaba que la validadicon sea exitosa.');
    }
}