<?php

use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class TipoTorneoTest extends TestCase
{	
	use DatabaseTransactions;
    use WithoutMiddleware;

    protected $modelMock;
    protected $requestMock;

    public function setUp()
	{
		parent::createApplication();
		$this->modelMock = Mockery::mock('App\TipoTorneo');
		$this->requestMock = Mockery::mock('App\Http\Requests\TipoTorneoRequest');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearTipoTorneos()
	{
		return array(
			Factory::make('App\TipoTorneo'),
			Factory::make('App\TipoTorneo'),
		);
	}

	protected function crearTipoTorneosPaginados()
	{
		return new Paginator($this->crearTipoTorneos(), 5);
	}

	public function index_trae_arreglo_de_tipotorneos()
	{

		$tipoTorneoPaginados = $this->crearTipoTorneosPaginados();

		$this->modelMock->shouldReceive('paginate')->once()->andReturn($tipoTorneoPaginados);
		$this->app->instance('App\TipoTorneo', $this->modelMock);

		$response = $this->call('GET', '/tipo_torneo');

		$this->assertViewHas('tipo_torneo', $tipoTorneoPaginados);
		$this->seePageIs('/tipo_torneo');
	}

	public function test_Index_no_muestra_mensajes_si_no_existe_keyword_y_trae_array()
	{	
		$this->index_trae_arreglo_de_tipotorneos();
	}

	public function test_Index_redirecciona_hacia_Create()
	{
		$tipoTorneoPaginados = $this->crearTipoTorneosPaginados();

		$this->modelMock->shouldReceive('paginate')->once()->andReturn($tipoTorneoPaginados);
		$this->app->instance('App\TipoTorneo', $this->modelMock);

		$this->visit('/tipo_torneo');
		$this->click('Agregar un Tipo de torneo');
		$this->seePageIs('/tipo_torneo/create');
	}

	public function store_guarda_objeto_y_redirecciona_hacia_index($tipoTorneo)
	{
		Flash::shouldReceive('success')->once()->with("Tipo de torneo creado exitosamente");

		$this->app->instance('App\TipoTorneo', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/tipo_torneo', $tipoTorneo);

		$this->assertRedirectedTo('/tipo_torneo');
	}
	
	public function test_Store()
	{
		$lugar = factory(App\TipoTorneo::class)->make();

		$crear = Factory::attributesFor(
			'App\TipoTorneo', [
				'ttr_descripcion' => $lugar->ttr_descripcion,
				'ttr_nombre' => $lugar->ttr_nombre,
		]); 
	
		$this->store_guarda_objeto_y_redirecciona_hacia_index($crear);
	}

	public function test_edit_devuelve_tipotorneo()
	{
		$tipo_torneo = Factory::make('App\TipoTorneo',['ttr_nombre' => 'Ecuador']);

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($tipo_torneo);
		$this->app->instance('App\TipoTorneo', $this->modelMock);

		$response = $this->call('GET', '/tipo_torneo/1/edit');
		$this->assertViewHas('tipo_torneo', $tipo_torneo);
	}

	public function update_actualiza_registro_y_redirecciona_hacia_Index($lugar)
	{
		Flash::shouldReceive('success')->once()->with("Tipo de torneo actualizado correctamente");

		$this->app->instance('App\TipoTorneo', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/tipo_torneo/1', $lugar);

		$this->assertRedirectedTo('/tipo_torneo');
	}

	public function test_Update()
	{
		$lugar = factory(App\TipoTorneo::class)->make();

		$crear = Factory::attributesFor(
			'App\TipoTorneo', [
				'ttr_descripcion' => $lugar->ttr_descripcion,
				'ttr_nombre' => $lugar->ttr_nombre]
		); 

		$this->update_actualiza_registro_y_redirecciona_hacia_Index($crear);
	}

	public function destroy_borra_registro()
	{
		Flash::shouldReceive('warning')->once()->with("Tipo de torneo borrado correctamente");

		$this->app->instance('App\TipoTorneo', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('delete')->once()->andReturn('true');
		
		$response = $this->call('DELETE', '/tipo_torneo/1');
		$this->assertRedirectedTo('/tipo_torneo');
	}

	public function test_Destroy_borra_registro_sin_imagen()
	{
		$this->destroy_borra_registro();
	}

}