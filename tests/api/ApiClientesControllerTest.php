<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiTablasControllerTest extends TestCase
{
	use DatabaseTransactions, WithoutMiddleware;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
    }

    public function test_tabla_if_torneo_exists_in_url()
    {
        $cliente = factory(App\Cliente::class)->create();

        $url = '/api/clientes';

        $response = $this->call('GET', $url);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(1, count($data),'Se esperaba 1 respuesta');

        $this->assertEquals($data[0]->clt_id, 1);
    }
}