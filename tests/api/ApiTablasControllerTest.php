<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiTablasControllerTest extends TestCase
{
	use DatabaseTransactions;

	public function setUp()
    {
    	parent::createApplication();
        Artisan::call('migrate:refresh');
    }

    public function test_tabla_if_torneo_exists_in_url()
    {
        $fase = factory(App\Fase::class)->create();

        $url = 'api/tablas/' . $fase->tor_id;

        $response = $this->call('GET', $url);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(1, count($data),'Se esperaba 1 respuesta');

        $this->assertEquals($data->torneo->tor_id, $fase->tor_id);
        $this->assertEquals($data->fases[0]->fas_id, $fase->fas_id);

        $this->assertEquals(1, count($data->fases));

        $posiciones = is_object($data->posiciones);
        $this->assertTrue($posiciones);
    }

    public function test_tabla_if_torneo_exists_in_url_with_2_fases()
    {
        $fase = factory(App\Fase::class, 2)->create();

        DB::table('fases')
            ->where('fas_id', 2)
            ->update(['tor_id' => 1, 'fas_acumulada' => 0]);

        $url = 'api/tablas/' . $fase[0]->tor_id;

        $response = $this->call('GET', $url);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(1, count($data),'Se esperaba 1 respuesta');

        $this->assertEquals(2, count($data->fases));

        $posiciones = is_object($data->posiciones);
        $this->assertTrue($posiciones);
    }

    public function test_tabla_if_torneo_exists_and_see_acumulado()
    {
        $fase = factory(App\Fase::class, 2)->create();

        DB::table('fases')
            ->where('fas_id', 2)
            ->update(['tor_id' => 1, 'fas_acumulada' => 1]);

        DB::table('fases')
            ->where('fas_id', 1)
            ->update(['fas_acumulada' => 1]);

        $url = 'api/tablas/' . $fase[0]->tor_id;

        $response = $this->call('GET', $url);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(1, count($data),'Se esperaba 1 respuesta');

        $this->assertEquals($data->torneo->tor_id, $fase[0]->tor_id);

        $this->assertEquals(2, count($data->fases));

        $posiciones = is_object($data->posiciones);
        $this->assertTrue($posiciones);

        $this->assertTrue(is_array($data->posiciones->acumulada));
    }

}