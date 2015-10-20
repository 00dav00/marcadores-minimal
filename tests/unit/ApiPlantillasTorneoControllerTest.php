<?php

// use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiPlantillasTorneoControllerTest extends TestCase
{	
    use WithoutMiddleware;

    public function setUp()
    {
    	parent::createApplication();
        Artisan::call('migrate:refresh');
    }

    public function test_Index_devuelve_json_array()
    {

    	$cantidad = 3;
        $plantillas = factory(App\PlantillaTorneo::class, $cantidad)->create();
    	
    	$response = $this->call('GET', 'api/plantillasTorneo');
    	$data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
		$this->assertEquals($cantidad, count($data),'Se esperaba '. $cantidad . ' plantillas');
    }


    public function test_Store_devuelve_objeto_insertado()
    {        
        $plantilla = factory(App\PlantillaTorneo::class)->make();

        $response = $this->call('POST', 'api/plantillasTorneo', $plantilla->attributesToArray());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->seeInDatabase('plantillas_torneo', ['plt_id' => json_decode($response->getContent())->plt_id]);
    }

    public function test_Show_devuelve_objeto_buscado()
    {
        $plantilla = factory(App\PlantillaTorneo::class)->create();

        $response = $this->call('GET', 'api/plantillasTorneo/'.$plantilla->attributesToArray()['plt_id']);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals($data->plt_id, $plantilla->attributesToArray()['plt_id'], 'Se esperaba clave igual');
        $this->assertEquals($data->plt_numero_camiseta, $plantilla->attributesToArray()['plt_numero_camiseta'], 'Se esperaba camiseta igual');
    }

    public function test_Update_devuelve_200_cuando_es_exitoso()
    {
        $plantilla = factory(App\PlantillaTorneo::class)->create();

        $plantilla->plt_numero_camiseta = 100;        

        $response = $this->call('PATCH', 'api/plantillasTorneo/'.$plantilla->attributesToArray()['plt_id'], $plantilla->attributesToArray());

        $this->assertResponseOk();
        $this->assertEquals(null,$response->getContent());
        $this->seeInDatabase('plantillas_torneo', [
            'plt_id'                =>  $plantilla->attributesToArray()['plt_id'], 
            'plt_numero_camiseta'   =>  $plantilla->attributesToArray()['plt_numero_camiseta']
        ]);
    }

    public function test_Update_devuelve_404_cuendo_no_existe_registro()
    {
        $plantilla = factory(App\PlantillaTorneo::class)->make();

        $response = $this->call('PATCH', 'api/plantillasTorneo/1', $plantilla->attributesToArray());
        $this->assertResponseStatus(404);
    }
 
    public function test_Destroy_devuelve_200_cuando_es_exitoso()
    {
        $plantilla = factory(App\PlantillaTorneo::class)->create();

        $this->seeInDatabase('plantillas_torneo', ['plt_id' =>  $plantilla->attributesToArray()['plt_id']]);

        $response = $this->call('DELETE', 'api/plantillasTorneo/'.$plantilla->attributesToArray()['plt_id']);

        $this->assertResponseOk();
        $this->assertEquals(null,$response->getContent());
        
        $this->notSeeInDatabase('plantillas_torneo', ['plt_id' =>  $plantilla->attributesToArray()['plt_id']]);
    }   

    public function test_Destroy_devuelve_404_cuendo_no_existe_registro()
    {
        $response = $this->call('DELETE', 'api/plantillasTorneo/1');
        $this->assertResponseStatus(404);
    }
}