<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BladeTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testIndex()
    {
        $this->visit('/tipo_fase')
        	->see('Tipo de fases');
    }

    public function testCreate()
	{
	    $this->visit('/tipo_fase')
	         ->click('Agregar un Tipo de fase')
	         ->seePageIs('/tipo_fase/create');
	}

	public function testBladeProccessToCreate()
	{
	    $this->visit('/tipo_fase/create')
	        ->type('Etapa Prueba', 'tfa_nombre')
	        ->type('Etapa Prueba', 'tfa_descripcion')
	        ->press('Agregar')
	        ->seePageIs('/tipo_fase')
	        ->seeInDatabase('tipo_fases', ['tfa_nombre' => 'Etapa Prueba']);

	    $tfa_id = DB::table('tipo_fases')
    		->where('tfa_nombre', '=', 'Etapa Prueba')
    		->value('tfa_id');

    	$this->visit('/tipo_fase/' . $tfa_id)
        	->see('Información del tipo de fase')
        	->press('Editar')
        	->seePageIs('/tipo_fase/' . $tfa_id . '/edit')
        	->type('Etapa Prueba Modificada', 'tfa_nombre')
	        ->type('Etapa Prueba Modificada', 'tfa_descripcion')
        	->press('Editar')
	        ->seePageIs('/tipo_fase')
	        ->seeInDatabase('tipo_fases', ['tfa_nombre' => 'Etapa Prueba Modificada']);
	}

	public function testControllerMethods()
	{
		/**
		 * create
		 */
		$this->call('POST', '/tipo_fase', ['tfa_nombre' => 'Etapa Prueba', 
			'tfa_descripcion' => 'Etapa Prueba Descripcion']);
		$this->seeInDatabase('tipo_fases', ['tfa_nombre' => 'Etapa Prueba']);

		/**
		 * get
		*/
		$response = $this->call('GET', '/tipo_fase');

		$this->assertEquals(200, $response->status());


		$tfa_id = DB::table('tipo_fases')
    		->where('tfa_nombre', '=', 'Etapa Prueba')
    		->value('tfa_id');

    	/**
    	 * editar
    	 */
		$this->call('PUT', '/tipo_fase/' . $tfa_id, ['tfa_nombre' => 'Etapa Prueba Editada', 
			'tfa_descripcion' => 'Etapa Prueba Descripcion Editada']);
		$this->seeInDatabase('tipo_fases', ['tfa_nombre' => 'Etapa Prueba Editada']);

		/**
		 * borrar
		 */
		$this->call('DELETE', '/tipo_fase/' . $tfa_id);
		$this->notSeeInDatabase('tipo_fases', ['tfa_nombre' => 'Etapa Prueba Editada']);
	}

}