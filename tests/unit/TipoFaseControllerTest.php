<?php

use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
// use Way\Tests\Factory;

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
		$this->modelMock = Mockery::mock('App\TipoFase');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearTipoFases()
	{
		return factory(App\TipoFase::class, 10)->make();
	}

	protected function crearTipoFasesPaginados()
	{
		return new Paginator($this->crearTipoFases(), 5);
	}

	public function test_index_trae_arreglo_de_de_tipofases()
	{

		$tipoFasesPaginados = $this->crearTipoFasesPaginados();

		$this->modelMock->shouldReceive('paginate')->once()->andReturn($tipoFasesPaginados);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$response = $this->call('GET', '/tipo_fase');

		$this->assertViewHas('tipo_fase', $tipoFasesPaginados);
		$this->seePageIs('/tipo_fase');
	}

	public function test_Index_redirecciona_hacia_Create()
	{
		$tipoFasesPaginados = $this->crearTipoFasesPaginados();

		$this->modelMock->shouldReceive('paginate')->once()->andReturn($tipoFasesPaginados);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$this->visit('/tipo_fase');
		$this->click('Agregar un Tipo de fase');
		$this->seePageIs('/tipo_fase/create');
	}

	public function test_store_guarda_objeto_y_redirecciona_hacia_index()
	{
		$tipoFase = factory(App\TipoFase::class)->make();

		Flash::shouldReceive('success')->once()->with("Tipo de fase creada exitosamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/tipo_fase', $tipoFase->attributesToArray());

		$this->assertRedirectedTo('/tipo_fase');
	}
	
	public function test_edit_devuelve_de_tipofase()
	{
		$tipoFase = factory(App\TipoFase::class)->make();

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($tipoFase);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$response = $this->call('GET', '/tipo_fase/1/edit');
		$this->assertViewHas('tipo_fase', $tipoFase);
	}

	public function test_update_actualiza_registro_y_redirecciona_hacia_Index()
	{
		$tipoFase = factory(App\TipoFase::class)->make();

		Flash::shouldReceive('success')->once()->with("Tipo de fase actualizada correctamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/tipo_fase/1', $tipoFase->attributesToArray());

		$this->assertRedirectedTo('/tipo_fase');
	}

	public function test_destroy_borra_registro()
	{
		Flash::shouldReceive('warning')->once()->with("Tipo de fase borrada correctamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('delete')->once()->andReturn('true');
		
		$response = $this->call('DELETE', '/tipo_fase/1');
		$this->assertRedirectedTo('/tipo_fase');
	}

}