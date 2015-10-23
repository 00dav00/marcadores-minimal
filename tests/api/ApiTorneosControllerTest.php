<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiTorneosControllerTest extends TestCase
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
        $plantillas = factory(App\Torneo::class, $cantidad)->create();
    	
    	$response = $this->call('GET', 'api/torneos');
    	$data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
		$this->assertEquals($cantidad, count($data),'Se esperaba '. $cantidad . ' plantillas');
    }

    public function test_Show_devuelve_objeto_buscado()
    {
        $torneo = factory(App\Torneo::class)->create();

        $response = $this->call('GET', 'api/torneos/'.$torneo->attributesToArray()['tor_id']);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals($data->tor_id, $torneo->attributesToArray()['tor_id'], 'Se esperaba clave igual');
        $this->assertEquals($data->tor_nombre, $torneo->attributesToArray()['tor_nombre'], 'Se esperaba nombre igual');
    }

    public function test_Consulta_devuelve_json_array_al_buscar_nombre()
    {
        $torneo = factory(App\Torneo::class)->create();

        $response = $this->call('GET', 'api/torneos/consulta', ['nombre' => $torneo->attributesToArray()['tor_nombre']]);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals($data[0]->tor_id, $torneo->attributesToArray()['tor_id'], 'Se esperaba clave igual');
        $this->assertEquals($data[0]->tor_nombre, $torneo->attributesToArray()['tor_nombre'], 'Se esperaba nombre igual');
    }

    public function test_EquiposParticipantes_devuelve_json_array_con_equipos()
    {
        $cantidad = 3;
        $torneo = factory(App\Torneo::class)->create();
        $equipos = factory(App\Equipo::class, $cantidad)->create();
        $equiposParticipantes = array();

        foreach($equipos as $equipo)
        {
            $equiposParticipantes[] = App\EquipoParticipante::create([
                'eqp_id' => $equipo->eqp_id,
                'tor_id' => $torneo->tor_id,
            ]);
        }

        $response = $this->call('GET', 'api/torneos/'.$torneo->attributesToArray()['tor_id'].'/equipos');
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertCount($cantidad, $data);
    }

    public function test_Fases_devuelve_json_array_con_fases()
    {
        $fase = factory(App\Fase::class)->create();

        $response = $this->call('GET', 'api/torneos/'.$fase->attributesToArray()['tor_id'].'/fases');
        $data = json_decode($response->getContent());
        
        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals($fase->attributesToArray()['fas_id'], $data[0]->fas_id);
    }

    public function test_Penalizaciones_devuelve_json_array_con_penalizaciones()
    {
        $penalizacion = factory(App\PenalizacionTorneo::class)->create();

        $response = $this->call('GET', 'api/torneos/1/penalizaciones');
        $data = json_decode($response->getContent());
        
        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals($penalizacion->attributesToArray()['fas_id'], $data[0]->fas_id);
        $this->assertEquals($penalizacion->attributesToArray()['eqp_id'], $data[0]->eqp_id);
    }
}