<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiLugaresControllerTest extends TestCase
{
    use WithoutMiddleware;
   
    public function setUp()
    {
        parent::createApplication();
        Artisan::call('migrate:refresh');
    }

    public function test_Consulta_devuelve_json_array_al_buscar_nombre_sin_tipo_lugar()
    {    
        $lugar = factory(App\Lugar::class)->create();

        $response = $this->call('GET', 'api/lugares/consulta/all?nombre='. $lugar->lug_nombre);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(1, count($data),'Se esperaba 1 jugador');
    }

    public function test_Consulta_devuelve_json_array_al_buscar_nombre_con_tipo_lugar()
    {    
        $lugar = factory(App\Lugar::class)->create();

        $response = $this->call('GET', 'api/lugares/consulta/'. $lugar->lug_tipo .'?nombre='. $lugar->lug_nombre);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(1, count($data),'Se esperaba 1 jugador');
    }

    public function test_Consulta_devuelve_json_array_vacio_al_buscar_nombre_con_tipo_lugar_incorrecto()
    {    
        $lugar = factory(App\Lugar::class)->create();
        $terms = ['continente', 'pais', 'provincia', 'ciudad'];
        unset($terms[array_search($lugar->lug_tipo, $terms)]);
        $terms = array_values($terms);

        $response = $this->call('GET', 'api/lugares/consulta/'. $terms[0] .'?nombre='. $lugar->lug_nombre);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(array(), $data,'Se esperaba un array vacìo');
    }    

    public function test_Consulta_devuelve_json_array_vacio_al_buscar_nombre_incorrecto()
    {    
        $lugar = factory(App\Lugar::class)->create();
        $terms = ['pais','continente','ciudad'];
        unset($terms[array_search($lugar->lug_tipo, $terms)]);

        $response = $this->call('GET', 'api/lugares/consulta/all?nombre=QWERTYUIOPLKJHGFDSA1234567890');
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(array(), $data,'Se esperaba un array vacìo');
    }    

    

}