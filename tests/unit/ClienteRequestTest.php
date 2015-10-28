<?php

use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Requests\ClienteRequest;

class ClienteRequestTest extends TestCase
{	
	use DatabaseTransactions;
    use WithoutMiddleware;

    private $rules;
    private $messages;

    public function setUp()
    {
    	parent::createApplication();
        $this->rules = ClienteRequest::$rules;
    	$this->messages = ClienteRequest::$messages;
    }

    public function test_validacion_falla_por_campos_vacios()
    {
    	$cliente = Factory::attributesFor(
			'App\Cliente',
			[
                'clt_nombre' => '',
                'clt_descripcion' => '',
                'clt_dominio' => ''
            ]
		);

		$validator = Validator::make($cliente, $this->rules, $this->messages);
		
		$this->assertFalse($validator->passes(),'Se esperaba que falle la validacion.');
		
        $this->assertTrue($validator->errors()->has('clt_nombre'),'Se esperaba que exista la clave clt_nombre');
		$this->assertCount(1, $validator->errors()->get('clt_nombre'),'Se esperaba que exista 1 error en la clave clt_nombre');

		$this->assertTrue($validator->errors()->has('clt_dominio'),'Se esperaba que exista la clave clt_dominio');
		$this->assertCount(1, $validator->errors()->get('clt_dominio'),'Se esperaba que exista 1 error en la clave clt_dominio');

		$this->assertCount(2, $validator->errors()->all(), 'Se esperaban 2 errores de validacion');
    
    }

    public function test_validacion_falla_por_campos_demasiado_cortos()
    {

        $cliente = Factory::attributesFor(
            'App\Cliente',
            [
                'clt_nombre' => 'aa',
                'clt_descripcion' => 'aa',
                'clt_dominio' => ''
            ]
        );

        $validator = Validator::make($cliente, ClienteRequest::$rules, ClienteRequest::$messages);

        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

        $this->assertTrue($validator->errors()->has('clt_nombre'),'Se esperaba que exista la clave clt_nombre');
        $this->assertCount(1, $validator->errors()->get('clt_nombre'),'Se esperaba que exista 1 error en la clave clt_nombre');

        $this->assertTrue($validator->errors()->has('clt_descripcion'),'Se esperaba que exista la clave clt_descripcion');
        $this->assertCount(1, $validator->errors()->get('clt_descripcion'),'Se esperaba que exista 1 error en la clave clt_descripcion');
    }

    public function test_validacion_falla_url_cliente()
    {
        $cliente = Factory::attributesFor(
            'App\Cliente',
            [
                'clt_nombre' => 'aaaa',
                'clt_descripcion' => 'aaaa',
                'clt_dominio' => 'aa'
            ]
        );
  
        $validator = Validator::make($cliente, ClienteRequest::$rules, ClienteRequest::$messages);

        $this->assertFalse($validator->passes(),'Se esperaba que falle la validadicon.');

        $this->assertTrue($validator->errors()->has('clt_dominio'),'Se esperaba error por formato del campo clt_dominio');
        $this->assertCount(1, $validator->errors()->get('clt_dominio'),'Se esperaba que exista 1 error en la clave clt_dominio');

        $this->assertCount(1, $validator->errors()->all(), 'Se esperaban 1 errores de validacion');
    }

    public function test_validacion_exitosa_con_formato_de_url()
    {
        
        $clienteFake = factory(App\Cliente::class)->make();

        $cliente = Factory::attributesFor(
            'App\Cliente',
            [
                'clt_nombre' => $clienteFake->clt_nombre,
                'clt_descripcion' => '',
                'clt_dominio' => $clienteFake->clt_dominio
            ]
        );

        $validator = Validator::make($cliente, ClienteRequest::$rules, ClienteRequest::$messages);

        $this->assertTrue($validator->passes(),'Se esperaba que la validacion de url sea exitosa.');
    }
}