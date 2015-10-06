<?php

use Way\Tests\Factory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Pagination\Paginator;

class JugadoresControllerTest extends TestCase
{	
	use DatabaseTransactions;
    use WithoutMiddleware;

    // public static function setUpBeforeClass()
    // {
    //     Artisan::call('migrate:refresh');
    // }
    protected $mock;

    public function setUp()
	{
		parent::createApplication();
		$this->mock = Mockery::mock('App\Jugador');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearJugadores()
	{
		return array(
			Factory::make('App\Jugador'),
			Factory::make('App\Jugador'),
		);
	}

	protected function crearJugadoresPaginados()
	{
		return new Paginator($this->crearJugadores(), 5);
	}

	public function index_trae_arreglo_de_jugadores($keyword)
	{
		$campos = array('campo' => 'descripcion');
		// $keyword = 'Nombre';	
		$columna = 'Nombre';
		$jugadoresPaginados = $this->crearJugadoresPaginados();


		// Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");
		$this->mock->shouldReceive('search')->once()->andReturn($jugadoresPaginados);
		$this->mock->shouldReceive('getSearchFields')->once()->andReturn($campos);
		$this->app->instance('App\Jugador', $this->mock);

		$response = $this->call('GET', '/jugadores', ['keyword' => $keyword, 'column' => $columna]);

		$this->assertViewHas('jugadores', $jugadoresPaginados);
		$this->assertViewHas('searchFields', $campos);
		$this->assertViewHas('keyword', $keyword);
		$this->assertViewHas('column', $columna);
	}

	public function test_Index_muestra_mensajes_si_existe_keyword()
	{
		$keyword = 'Nombre';	
		Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");

		$this->index_trae_arreglo_de_jugadores($keyword);
	}
	
	public function test_Index_no_muestra_mensajes_si_no_existe_keyword()
	{
		$keyword = '';	
		Flash::shouldReceive('info')->never();

		$this->index_trae_arreglo_de_jugadores($keyword);
	}


}