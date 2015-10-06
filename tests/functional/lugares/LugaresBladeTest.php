<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LugaresBladeTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testSeeIndex()
    {
        $this->visit('/lugares')
        	->see('Lugares');
    }

    public function testSeeCreate()
	{
	    $this->visit('/lugares')
	         ->click('Agregar un Lugar')
	         ->seePageIs('/lugares/create');
	}

	public function testCreate()
	{

		$lugar = factory(App\Lugar::class)
					->make();

	    $this->visit('/lugares/create')
	        ->type($lugar->lug_abreviatura, 'lug_abreviatura')
	        ->type($lugar->lug_nombre, 'lug_nombre')
	        ->type($lugar->lug_tipo, 'lug_tipo')
	        ->press('Agregar');
	        // ->seePageIs('/lugares')
	        // ->seeInDatabase('lugares', ['lug_nombre' => $lugar->lug_nombre]);
	}

	public function testSeeEditar()
	{

		$lugar = factory(App\Lugar::class,10)
					->create();

	// 	$this->visit('/lugares/' . $lugar[0]->lug_id . '/edit')
	// 		->type('PRB', 'lug_abreviatura')
	//         ->type('Nombre Prueba', 'lug_nombre')
	//         //->$this->select($lugar[7]->lug_id, 'parent_lug_id')
	//         ->press('Editar')
	//         ->seePageIs('/lugares')
	//         ->seeInDatabase('lugares', ['lug_nombre' => 'Nombre Prueba']);


	// }

	// public function testBusqueda()
	// {
	// 	$lugar = factory(App\Lugar::class)
	// 				->create();

	// 	$this->visit('/lugares')
	// 			->type($lugar->lug_abreviatura, 'keyword')
	// 			->select('lug_abreviatura', 'column')
	// 			->press('Buscar')
	// 			->see($lugar->lug_nombre);
	}

}