<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ApiPersonalizacionValoresControllerTest extends TestCase
{	
    use WithoutMiddleware;

    public function setUp()
    {
    	parent::createApplication();
        Artisan::call('migrate:refresh');
    }

    public function test_get_personalizacion_campos()
    {        
        $url = '/api/personalizacion_campos';

        $response = $this->call('GET', $url);
        $data = json_decode($response->getContent());

        $this->assertJson($response->getContent(),'Se esperaba JSON');
        $this->assertEquals(5, count($data),'Se esperaba 6 campos');
    }

}