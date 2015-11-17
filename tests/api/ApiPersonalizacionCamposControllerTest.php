<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiPersonalizacionCamposControllerTest extends TestCase
{
	use DatabaseTransactions, WithoutMiddleware;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

    public function test_products_list()
    {

        $url = '/api/personalizacion_campos';

        $response = $this->call('GET', $url);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(7, count($data),'Se esperaba 7 elementos');

        $this->assertEquals($data[0]->pca_id, 1);
    }
}