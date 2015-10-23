<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiPenalizacionesTorneoControllerTest extends TestCase
{	
    use WithoutMiddleware;

    public function setUp()
    {
    	parent::createApplication();
        Artisan::call('migrate:refresh');
    }

    public function test_Store_devuelve_objeto_insertado()
    {        
        $penalizacion = factory(App\PenalizacionTorneo::class)->make();

        $response = $this->call('POST', 'api/penalizaciones', $penalizacion->attributesToArray());
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->seeInDatabase('penalizaciones_torneo', ['ptr_id' => $data->ptr_id]);
    }

    public function test_Update_devuelve_200_cuando_es_exitoso()
    {        
        $penalizacion = factory(App\PenalizacionTorneo::class)->create();
        $puntosOriginales = $penalizacion->ptr_puntos;
        $penalizacion->ptr_puntos += 1;

        $response = $this->call('PUT', 'api/penalizaciones/'. $penalizacion->attributesToArray()['ptr_id'], $penalizacion->attributesToArray());
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->seeInDatabase('penalizaciones_torneo', ['ptr_id' => $penalizacion->ptr_id, 'ptr_puntos' => $puntosOriginales + 1]);
    }

    public function test_Update_devuelve_404_cuendo_no_existe_registro()
    {
        $penalizacion = factory(App\PenalizacionTorneo::class)->make();

        $response = $this->call('PUT', 'api/penalizaciones/1', $penalizacion->attributesToArray());   
        $this->assertResponseStatus(404);
    }

    public function test_Destroy_devuelve_200_cuando_es_exitoso()
    {
        $penalizacion = factory(App\PenalizacionTorneo::class)->create();

        $response = $this->call('DELETE', 'api/penalizaciones/'. $penalizacion->attributesToArray()['ptr_id']);
        
        $this->assertResponseOk();
        $this->assertEquals(null,$response->getContent());

        $this->notSeeInDatabase('penalizaciones_torneo', ['ptr_id' => $penalizacion->ptr_id]);
    }

    public function test_Destroy_devuelve_404_cuendo_no_existe_registro()
    {
        $response = $this->call('DELETE', 'api/penalizaciones/1');
        $this->assertResponseStatus(404);
    }
}