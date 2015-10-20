<?php

use App\Http\Requests\TipoTorneoRequest;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TipoTorneoControllerTest extends TestCase
{
	use DatabaseTransactions;
    use WithoutMiddleware;

    public static function setUpBeforeClass()
    {
        Artisan::call('migrate:refresh');
    }

	public function setUp()
	{
		parent::createApplication();
		// parent::setUp();
		DB::beginTransaction();
	}

	public function test_pagina_de_indice_vacia()
    {
        $this->visit('/tipo_torneo')
        	->see('Tipo de torneos')
        	->dontSee('Detalles');
    }

    public function test_CRUD_TipoTorneo()
	{
	    $this->visit('/tipo_torneo')
	         ->click('Agregar un Tipo de torneo');

	    $ttr_nombre = 'Tipo torneo prueba' ;
	    $ttr_descripcion = 'Tipo torneo prueba' ;
	         
        $this->seePageIs('/tipo_torneo/create')
	    	 ->see('Agregar un Tipo de Torneo')
	    	 ->type($ttr_nombre, 'ttr_nombre')
	         ->type($ttr_descripcion, 'ttr_descripcion')
	         ->press('Agregar');

        $tipoTorneo = App\TipoTorneo::where('ttr_nombre', $ttr_nombre)->first();

        $this->assertEquals($ttr_nombre, $tipoTorneo->ttr_nombre);
    	$this->assertEquals($ttr_descripcion, $tipoTorneo->ttr_descripcion);

        $this->seePageIs('/tipo_torneo')
        	 ->see('Detalles')
        	 ->see($tipoTorneo->ttr_nombre)
        	 ->click('Detalles');

    	$this->seePageIs('/tipo_torneo/'.$tipoTorneo->ttr_id)
    		 ->see('Información del tipo de torneo')
    		 ->see($tipoTorneo->ttr_nombre)
    		 ->see($tipoTorneo->ttr_descripcion)
    		 ->press('Editar');

		$this->seePageIs('tipo_torneo/'.$tipoTorneo->ttr_id.'/edit')
			 ->assertViewHas('tipo_torneo', $tipoTorneo);
		$this->see('Agregar un Tipo de Torneo')
			 ->see($tipoTorneo->ttr_nombre)
    		 ->see($tipoTorneo->ttr_descripcion);

    	$tipoTorneo->ttr_nombre .= ' EDITADO';
		$tipoTorneo->ttr_descripcion .= ' EDITADO';

		$this->type($tipoTorneo->ttr_nombre, 'ttr_nombre')
    		 ->type($tipoTorneo->ttr_descripcion, 'ttr_descripcion')
			 ->press('Editar');


		// $this->seePageIs('tipo_torneo/')
		// 	 ->see('Tipo de torneo actualizado correctamente')
			 // ->see($tipoTorneo->ttr_nombre)
			 // ->see($tipoTorneo->ttr_descripcion)
			 // ->click('Detalles');


		// $this->seePageIs('/tipo_torneo/'.$tipoTorneo->ttr_id)
		// 	 ->see('Información del tipo de torneo')
		// 	 ->see($tipoTorneo->ttr_nombre)
		// 	 ->see($tipoTorneo->ttr_descripcion)
		// 	 ->press('Delete')
		// 	 ->see('seguro');
	}

	public function test_validacion_fallida_por_campos_vacios()
	{
		$tipo_torneo = array("ttr_nombre"=>"", "ttr_descripcion"=>"");
		$validator = Validator::make($tipo_torneo, TipoTorneoRequest::$rules, TipoTorneoRequest::$messages);
		$this->assertFalse($validator->passes());
		$this->assertEquals(
			$validator->errors()->first('ttr_nombre'),
			TipoTorneoRequest::$messages["ttr_nombre.required"]
		);
	}

	public function test_validacion_fallida_por_nombre_vacio()
	{
		$tipo_torneo = array("ttr_nombre"=>"", "ttr_descripcion"=>"ssssssss");
		$validator = Validator::make($tipo_torneo, TipoTorneoRequest::$rules, TipoTorneoRequest::$messages);
		$this->assertFalse($validator->passes());
		$this->assertEquals(
			$validator->errors()->first('ttr_nombre'),
			TipoTorneoRequest::$messages["ttr_nombre.required"]
		);
	}

	public function test_validacion_fallida_por_campos_demasiado_cortos()
	{
		$tipo_torneo = array("ttr_nombre"=>"a", "ttr_descripcion"=>"a");
		$validator = Validator::make($tipo_torneo, TipoTorneoRequest::$rules, TipoTorneoRequest::$messages);
		$this->assertFalse($validator->passes());
		$this->assertEquals(
			$validator->errors()->first('ttr_nombre'),
			str_replace(':min','3',TipoTorneoRequest::$messages["ttr_nombre.min"])
		);
		$this->assertEquals(
			$validator->errors()->first('ttr_descripcion'),
			str_replace(':min','3',TipoTorneoRequest::$messages["ttr_descripcion.min"])
		);
	}

	public function test_validacion_fallida_por_nombre_demasiado_corto()
	{
		$tipo_torneo = array("ttr_nombre"=>"a", "ttr_descripcion"=>"aaaaaaa");
		$validator = Validator::make($tipo_torneo, TipoTorneoRequest::$rules, TipoTorneoRequest::$messages);
		$this->assertFalse($validator->passes());
		$this->assertEquals(
			$validator->errors()->first('ttr_nombre'),
			str_replace(':min','3',TipoTorneoRequest::$messages["ttr_nombre.min"])
		);
	}


	public function test_validacion_fallida_por_descripcion_demasiado_corta()
	{
		$tipo_torneo = array("ttr_nombre"=>"aaaaa", "ttr_descripcion"=>"aa");
		$validator = Validator::make($tipo_torneo, TipoTorneoRequest::$rules, TipoTorneoRequest::$messages);
		$this->assertFalse($validator->passes());
		$this->assertEquals(
			$validator->errors()->first('ttr_descripcion'),
			str_replace(':min','3',TipoTorneoRequest::$messages["ttr_descripcion.min"])
		);
	}

	public function test_validacion_exitosa_solo_con_nombre()
	{
		$tipo_torneo = array("ttr_nombre"=>"aaaaa", "ttr_descripcion"=>"");
		$validator = Validator::make($tipo_torneo, TipoTorneoRequest::$rules, TipoTorneoRequest::$messages);
		$this->assertTrue($validator->passes());
	}

	public function test_validacion_exitosa_con_ambos_campos()
	{
		$tipo_torneo = array("ttr_nombre"=>"aaaaa", "ttr_descripcion"=>"sssssss");
		$validator = Validator::make($tipo_torneo, TipoTorneoRequest::$rules, TipoTorneoRequest::$messages);
		$this->assertTrue($validator->passes());
	}



	public function tearDown()
	{
		DB::rollBack();
		parent::tearDown();
	}
}

?>