<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiInternoTest extends TestCase
{

    //use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTipoFaseConsulta()
    {
    	$this->withoutMiddleware();
    	
        $this->get('/api/tipo_fase/consulta')
            ->seeJson();
    }
}