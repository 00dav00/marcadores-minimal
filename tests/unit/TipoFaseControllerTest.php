<?php

use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class TipoFaseControllerTest extends TestCase
{	
    use WithoutMiddleware;

    protected $modelMock;

    public function setUp()
	{
		parent::createApplication();
		// Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
		$this->modelMock = Mockery::mock('App\TipoFase');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearTiposFase()
	{
		return factory(App\TipoFase::class, 10)->make();
	}

	protected function crearTiposFasePaginados()
	{
		return new Paginator($this->crearTiposFase(), 5);
	}

	public function test_index_trae_arreglo_de_tipos_fase()
	{
		$campos = array('campo' => 'descripcion');
		$columna = 'Nombre';
		$tiposFasePaginados = $this->crearTiposFasePaginados();

		//TODO Integrar las pruebas de encadenamiento con parametros
		//->with(identicalTo(env('PAGINATION_NUMBER')))

		$this->modelMock->shouldReceive('orderBy->paginate')->once()->andReturn($tiposFasePaginados);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$response = $this->call('GET', '/tipo_fase');

		$this->assertViewHas('tipo_fase', $tiposFasePaginados);
		$this->seePageIs('/tipo_fase');
	}

	public function test_Index_redirecciona_hacia_Create()
	{
		$this->modelMock->shouldReceive('orderBy->paginate')->once()->andReturn($this->crearTiposFasePaginados());
		$this->app->instance('App\TipoFase', $this->modelMock);

		$this->visit('/tipo_fase');
		$this->click('Agregar un Tipo de fase'); 
		$this->seePageIs('/tipo_fase/create');
	}

	public function test_Store_guarda_objeto_y_redirecciona_hacia_index()
	{
		$tipoFase = factory(App\TipoFase::class)->make();

		Flash::shouldReceive('success')->once()->with("Tipo de fase creada exitosamente");
		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/tipo_fase', $tipoFase->attributesToArray());
		$this->assertRedirectedTo('/tipo_fase');
	}

	public function test_Show_devuelve_tipo_fase()
	{
		$tipoFase = $tipoFase = factory(App\TipoFase::class)->make();

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($tipoFase);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$response = $this->call('GET', '/tipo_fase/1');
		$this->assertViewHas('tipo_fase', $tipoFase);
	} 

	public function test_Show_redirecciona_hacia_Editar()
	{
		$tipoFase = $tipoFase = factory(App\TipoFase::class)->make();
		$tipoFase->tfa_id = 1;
		
		$this->modelMock->shouldReceive('findOrFail')->times(2)->andReturn($tipoFase);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$response = $this->visit('/tipo_fase/1');
		$this->press('Editar');
		$this->seePageIs('/tipo_fase/1/edit');
		$this->see($tipoFase->tfa_nombre);
	}

	public function test_update_actualiza_registro_y_redirecciona_hacia_Index()
	{
		$tipoFase = $tipoFase = factory(App\TipoFase::class)->make();

		Flash::shouldReceive('success')->once()->with("Tipo de fase actualizada correctamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/tipo_fase/1', $tipoFase->attributesToArray());
		$this->assertRedirectedTo('/tipo_fase');
	}

	public function test_Destroy_borra_registro()
	{
		Flash::shouldReceive('warning')->once()->with("Tipo de fase borrada correctamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('delete')->once()->andReturn('true');
 		
		$response = $this->call('DELETE', '/tipo_fase/1');
		$this->assertRedirectedTo('/tipo_fase');
	}
}