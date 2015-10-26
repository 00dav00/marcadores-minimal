<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientesIntegrationTest extends TestCase
{

    use WithoutMiddleware;

    public function tearDown()
    {
        DB::table('clientes')->truncate();
    }

    public function test_See_Index()
    {
        $this->visit('/clientes')
        	->see('Lista de Clientes');
    }

    public function test_See_Index_Busqueda()
    {
    	$clienteFake = 	factory(App\Cliente::class, 3)->create();

        $this->visit('/clientes')
        	->type($clienteFake[0]->clt_nombre, 'keyword')
        	->select('clt_nombre', 'column')
        	->seePageIs('/clientes')
        	->see($clienteFake[0]->clt_nombre);
    }

    public function test_See_Create()
	{
	    $this->visit('/clientes')
	         ->click('Agregar un Cliente')
	         ->seePageIs('/clientes/create');
	}

	public function test_Create()
	{
		$clienteFake = 	factory(App\Cliente::class)->make();

	    $this->visit('/clientes/create')
	    	->type($clienteFake->clt_nombre, 'clt_nombre')
	    	->type($clienteFake->clt_descripcion, 'clt_descripcion')
	    	->type($clienteFake->clt_dominio, 'clt_dominio')
	        ->press('Agregar')
	        ->seePageIs('/clientes')
	        ->see($clienteFake->clt_nombre);
	}

    public function test_See_Show()
    {
        $clienteFake =  factory(App\Cliente::class)->create();

        $this->visit('/clientes')
             ->click('Detalles')
             ->see('Información del Cliente');
    }

    public function test_Editar()
    {
        $clienteFake =  factory(App\Cliente::class)->create();

        $clt_id = DB::table('clientes')
            ->where('clt_nombre', '=', $clienteFake->clt_nombre)
            ->value('clt_id');

        $this->visit('/clientes/' . $clt_id)
            ->press('Editar')
            ->type('aaaa', 'clt_nombre')
            ->press('Editar')
            ->seePageIs('/clientes')
            ->see('aaaa');
    }

    public function test_Borrar()
    {
        $clienteFake =  factory(App\Cliente::class)->create();

        $clt_id = DB::table('clientes')
            ->where('clt_nombre', '=', $clienteFake->clt_nombre)
            ->value('clt_id');

        $this->visit('/clientes/' . $clt_id)
            ->press('Si')
            ->seePageIs('/clientes');

        $this->notSeeInDatabase('clientes', ['clt_nombre' => $clienteFake->clt_nombre]);
    }
}