<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiControllerTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLugaresConsulta()
    {    

        $this->get('/api/lugares/consulta/all')
            ->seeJson();

    }

    public function testGetLugaresConsulta()
    {    
        $lugares = factory(App\Lugar::class, 200)
            ->create();


        $this->get('/api/lugares/consulta/all?nombre=a')
            ->seeJson();

    }

}