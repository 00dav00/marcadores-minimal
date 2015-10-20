<?php

use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class LugaresControllerTest extends TestCase
{	
	use DatabaseTransactions;
    use WithoutMiddleware;

    protected $modelMock;
    protected $requestMock;

    public function setUp()
	{
		parent::createApplication();
		$this->modelMock = Mockery::mock('App\TipoFase');
		$this->requestMock = Mockery::mock('App\Http\Requests\TipoFaseRequest');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearTipoFases()
	{
		return array(
			Factory::make('App\TipoFase'),
			Factory::make('App\TipoFase'),
		);
	}

	protected function crearTipoFasesPaginados()
	{
		return new Paginator($this->crearTipoFases(), 5);
	}

	public function index_trae_arreglo_de_de_tipofases()
	{

		$tipoFasesPaginados = $this->crearTipoFasesPaginados();

		$this->modelMock->shouldReceive('paginate')->once()->andReturn($tipoFasesPaginados);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$response = $this->call('GET', '/tipo_fase');

		$this->assertViewHas('tipo_fase', $tipoFasesPaginados);
		$this->seePageIs('/tipo_fase');
	}

	public function test_Index_no_muestra_mensajes_si_no_existe_keyword_y_trae_array()
	{	
		$this->index_trae_arreglo_de_de_tipofases();
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

	public function store_guarda_objeto_y_redirecciona_hacia_index($tipoFase)
	{
		Flash::shouldReceive('success')->once()->with("Tipo de fase creada exitosamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/tipo_fase', $tipoFase);

		$this->assertRedirectedTo('/tipo_fase');
	}
	
	public function test_Store()
	{
		$lugar = factory(App\TipoFase::class)->make();

		$crear = Factory::attributesFor(
			'App\TipoFase', [
				'tfa_descripcion' => $lugar->tfa_descripcion,
				'tfa_nombre' => $lugar->tfa_nombre,
		]); 
	
		$this->store_guarda_objeto_y_redirecciona_hacia_index($crear);
	}

	public function test_edit_devuelve_de_tipofase()
	{
		$tipo_fase = Factory::make('App\TipoFase',['tfa_nombre' => 'Ecuador']);

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($tipo_fase);
		$this->app->instance('App\TipoFase', $this->modelMock);

		$response = $this->call('GET', '/tipo_fase/1/edit');
		$this->assertViewHas('tipo_fase', $tipo_fase);
	}

	public function update_actualiza_registro_y_redirecciona_hacia_Index($lugar)
	{
		Flash::shouldReceive('success')->once()->with("Tipo de fase actualizada correctamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/tipo_fase/1', $lugar);

		$this->assertRedirectedTo('/tipo_fase');
	}

	public function test_Update()
	{
		$lugar = factory(App\TipoFase::class)->make();

		$crear = Factory::attributesFor(
			'App\TipoFase', [
				'tfa_descripcion' => $lugar->tfa_descripcion,
				'tfa_nombre' => $lugar->tfa_nombre]
		); 

		$this->update_actualiza_registro_y_redirecciona_hacia_Index($crear);
	}

	public function destroy_borra_registro()
	{
		Flash::shouldReceive('warning')->once()->with("Tipo de fase borrada correctamente");

		$this->app->instance('App\TipoFase', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('delete')->once()->andReturn('true');
		
		$response = $this->call('DELETE', '/tipo_fase/1');
		$this->assertRedirectedTo('/tipo_fase');
	}

	public function test_Destroy_borra_registro_sin_imagen()
	{
		$this->destroy_borra_registro();
	}

}