<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiProductosControllerTest extends TestCase
{
	use DatabaseTransactions, WithoutMiddleware;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
    }

    public function test_products_list()
    {
        $producto = factory(App\Producto::class)->create();

        $url = '/api/productos';

        $response = $this->call('GET', $url);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(1, count($data),'Se esperaba 1 respuesta');

        $this->assertEquals($data[0]->prd_id, 1);
    }
}