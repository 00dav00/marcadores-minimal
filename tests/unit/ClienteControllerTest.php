<?php

use Illuminate\Pagination\Paginator;
use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ClienteControllerTest extends TestCase
{
	use DatabaseTransactions;
    use WithoutMiddleware;

    protected $modelMock;
    protected $requestMock;
    protected $imageMock;

    public function setUp()
	{
		parent::createApplication();
		$this->modelMock = Mockery::mock('App\Cliente');
		$this->requestMock = Mockery::mock('App\Http\Requests\ClienteRequest');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearClientes()
	{
		return array(
			Factory::make('App\Cliente'),
		);
	}

	protected function crearClientesPaginados()
	{
		return new Paginator($this->crearClientes(), 5);
	}

	public function index_trae_arreglo_de_clientes($keyword)
	{
		$campos = array('campo' => 'Nombre');
		$columna = 'Nombre';
		$clientesPaginados = $this->crearClientesPaginados();

		$this->modelMock->shouldReceive('search')->once()->andReturn($clientesPaginados);
		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn($campos);
		$this->app->instance('App\Cliente', $this->modelMock);

		$response = $this->call('GET', '/clientes', ['keyword' => $keyword, 'column' => $columna]);

		$this->assertViewHas('clientes', $clientesPaginados);
		$this->assertViewHas('searchFields', $campos);
		$this->assertViewHas('keyword', $keyword);
		$this->assertViewHas('column', $columna);
		$this->seePageIs('/clientes');
	}

    public function test_mostrar_index()
    {
    	$keyword = '';	
		
		Flash::shouldReceive('info')->never();

		$this->index_trae_arreglo_de_clientes($keyword);
    }

    public function test_mostrar_index_si_existe_keyword()
	{
		$keyword = 'Nombre';

		Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");

		$this->index_trae_arreglo_de_clientes($keyword);
	}

	public function test_index_redirecciona_hacia_create()
	{
		$this->modelMock->shouldReceive('search')->once()->andReturn($this->crearClientesPaginados());

		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn([]);
		$this->app->instance('App\Cliente', $this->modelMock);

		$this->visit('/clientes');
		$this->click('Agregar un Cliente');
		$this->seePageIs('/clientes/create');
	}

	public function store_guarda_objeto_y_redirecciona_hacia_index($cliente)
	{
		Flash::shouldReceive('success')->once()->with("Cliente creado exitosamente");

		$this->app->instance('App\Cliente', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/clientes', $cliente);
		$this->assertRedirectedTo('/clientes');
	}

	public function test_store()
	{	
		$clienteFake = 	factory(App\Cliente::class)->make();

		$cliente = Factory::attributesFor(
			'App\Cliente',
			[
				'clt_id' => '',
				'clt_nombre' => $clienteFake->clt_nombre,
				'clt_descripcion' => $clienteFake->clt_descripcion,
				'clt_dominio' => $clienteFake->clt_dominio
			]
		);  

		$this->store_guarda_objeto_y_redirecciona_hacia_index($cliente);		
	}

	public function test_show()
	{
		$clienteFake = 	factory(App\Cliente::class)->make();

		$cliente = Factory::make(
			'App\Cliente',
			[
				'clt_id' => 1,
				'clt_nombre' => $clienteFake->clt_nombre,
				'clt_descripcion' => $clienteFake->clt_descripcion,
				'clt_dominio' => $clienteFake->clt_dominio
			]
		);

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($cliente);
		$this->app->instance('App\Cliente', $this->modelMock);

		$response = $this->call('GET', '/clientes/1');
		$this->assertViewHas('cliente', $cliente);
	}

	public function test_show_redirecciona_hacia_editar()
	{
		$clienteFake = 	factory(App\Cliente::class)->make();

		$cliente = Factory::make(
			'App\Cliente',
			[
				'clt_id' => 1,
				'clt_nombre' => $clienteFake->clt_nombre,
				'clt_descripcion' => $clienteFake->clt_descripcion,
				'clt_dominio' => $clienteFake->clt_dominio
			]
		);
		
		$this->modelMock->shouldReceive('findOrFail')->twice()->andReturn($cliente);
		
		$this->app->instance('App\Cliente', $this->modelMock);

		$response = $this->visit('/clientes/1');
		$this->press('Editar');
		$this->seePageIs('/clientes/1/edit');
		$this->see($clienteFake->clt_nombre);
	}

	public function update_actualiza_registro_y_redirecciona_hacia_index($cliente)
	{
		Flash::shouldReceive('success')->once()->with("Cliente actualizado exitosamente");

		$this->app->instance('App\Cliente', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/clientes/1', $cliente);
		$this->assertRedirectedTo('/clientes');
	}

	public function test_update()
	{
		$clienteFake = 	factory(App\Cliente::class)->make();

		$cliente = Factory::attributesFor(
			'App\Cliente',
			[
				'clt_id' => 1,
				'clt_nombre' => $clienteFake->clt_nombre,
				'clt_descripcion' => $clienteFake->clt_descripcion,
				'clt_dominio' => $clienteFake->clt_dominio
			]
		);

		$this->update_actualiza_registro_y_redirecciona_hacia_index($cliente);
	}

	public function test_destroy()
	{
		Flash::shouldReceive('warning')->once()->with("Cliente borrado exitosamente");

		$this->app->instance('App\Cliente', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('delete')->once()->andReturn('true');
 		
		$response = $this->call('DELETE', '/clientes/1');
		$this->assertRedirectedTo('/clientes');
	}
}