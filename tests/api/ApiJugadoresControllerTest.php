<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiJugadoresControllerTest extends TestCase
{
	use WithoutMiddleware;

	public function setUp()
    {
    	parent::createApplication();
        Artisan::call('migrate:refresh');
    }

    public function test_Consulta_devuelve_json_array_al_buscar_nombre_apellido_o_apodo()
    {    
        $jugador = factory(App\Jugador::class)->create();
    	
    	/*Buscar por nombre*/
    	$response = $this->call('GET', 'api/jugadores/consulta',['nombre' => $jugador->attributesToArray()['jug_nombre']]);
    	$data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
		$this->assertEquals(1, count($data),'Se esperaba 1 jugador');

		/*Buscar por apellido*/
		$response = $this->call('GET', 'api/jugadores/consulta',['nombre' => $jugador->attributesToArray()['jug_apellido']]);
    	$data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
		$this->assertEquals(1, count($data),'Se esperaba 1 jugador');

		/*Buscar por apodo*/
		$response = $this->call('GET', 'api/jugadores/consulta',['nombre' => $jugador->attributesToArray()['jug_apodo']]);
    	$data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
		$this->assertEquals(1, count($data),'Se esperaba 1 jugador');
    }

    public function test_Consulta_devuelve_json_array_vacio_si_no_se_envia_parametro_nombre()
    {
    	$response = $this->call('GET', 'api/jugadores/consulta', ['nombre' => '']);
    	$data = json_decode($response->getContent());

    	$this->assertJson($response->getContent(),'Se esperaba JSON');
		$this->assertEquals(array(), $data,'Se esperaba un array vacìo');
    }
}