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
		$this->modelMock = Mockery::mock('App\Lugar');
		$this->requestMock = Mockery::mock('App\Http\Requests\LugarRequest');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearLugares()
	{
		return array(
			Factory::make('App\Lugar'),
			Factory::make('App\Lugar'),
		);
	}

	protected function crearLugaresPaginados()
	{
		return new Paginator($this->crearLugares(), 5);
	}

	public function index_trae_arreglo_de_lugares($keyword)
	{
		$campos = array('lug_nombre' => 'Nombre', 'lug_abreviatura' => 'Abreviatura');
		// $keyword = 'Nombre';	
		$columna = 'Nombre';
		$lugaresPaginados = $this->crearLugaresPaginados();


		// Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");
		$this->modelMock->shouldReceive('search')->once()->andReturn($lugaresPaginados);
		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn($campos);
		$this->app->instance('App\Lugar', $this->modelMock);

		$response = $this->call('GET', '/lugares', ['keyword' => $keyword, 'column' => $columna]);

		$this->assertViewHas('lugares', $lugaresPaginados);
		$this->assertViewHas('searchFields', $campos);
		$this->assertViewHas('keyword', $keyword);
		$this->assertViewHas('column', $columna);
		$this->seePageIs('/lugares');
	}

	public function test_Index_muestra_mensajes_si_existe_keyword_y_trae_array()
	{
		$keyword = 'Nombre';	
		Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");

		$this->index_trae_arreglo_de_lugares($keyword);
	}

	public function test_Index_no_muestra_mensajes_si_no_existe_keyword_y_trae_array()
	{
		$keyword = '';	
		Flash::shouldReceive('info')->never();

		$this->index_trae_arreglo_de_lugares($keyword);
	}

	public function test_Index_redirecciona_hacia_Create()
	{
		$this->modelMock->shouldReceive('search')->once()->andReturn($this->crearLugaresPaginados());
		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn([]);
		$this->app->instance('App\Lugar', $this->modelMock);

		$this->visit('/lugares');
		$this->click('Agregar un Lugar');
		$this->seePageIs('/lugares/create');
	}

	public function store_guarda_objeto_y_redirecciona_hacia_index($lugar)
	{
		Flash::shouldReceive('success')->once()->with("Lugar creado exitosamente");

		$this->app->instance('App\Lugar', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/lugares', $lugar);

		$this->assertRedirectedTo('/lugares');
	}
	
	public function test_Store()
	{
		$lugar = factory(App\Lugar::class)->make();

		$crear = Factory::attributesFor(
			'App\Lugar', [
				'lug_abreviatura' => $lugar->lug_abreviatura,
				'lug_nombre' => $lugar->lug_nombre,
				'lug_tipo' => $lugar->lug_tipo,
				'parent_lug_id' => '']
		); 
	
		$this->store_guarda_objeto_y_redirecciona_hacia_index($crear);
	}

	public function test_edit_devuelve_lugar()
	{
		$lugar = Factory::make('App\Lugar',['lug_nombre' => 'Ecuador']);

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($lugar);
		$this->app->instance('App\Lugar', $this->modelMock);

		$response = $this->call('GET', '/lugares/1/edit');
		$this->assertViewHas('lugar', $lugar);
	}

	public function update_actualiza_registro_y_redirecciona_hacia_Index($lugar)
	{
		Flash::shouldReceive('success')->once()->with("Lugar actualizado exitosamente");

		$this->app->instance('App\Lugar', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/lugares/1', $lugar);
		//$this->see('asdasd');
		//var_dump($response->getSession());
		//$this->assertResponseOk(); 

		$this->assertRedirectedTo('/lugares');
	}

	public function test_Update()
	{
		$lugar = factory(App\Lugar::class)->make();

		$crear = Factory::attributesFor(
			'App\Lugar', [
				'lug_abreviatura' => $lugar->lug_abreviatura,
				'lug_nombre' => $lugar->lug_nombre,
				'lug_tipo' => $lugar->lug_tipo,
				'parent_lug_id' => '']
		); 

		$this->update_actualiza_registro_y_redirecciona_hacia_Index($crear);
	}

}