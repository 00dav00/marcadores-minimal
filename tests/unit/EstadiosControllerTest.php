<?php

use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class EstadiosControllerTest extends TestCase
{	
	use DatabaseTransactions;
    use WithoutMiddleware;

    // public static function setUpBeforeClass()
    // {
    //     Artisan::call('migrate:refresh');
    // }
    protected $modelMock;
    protected $requestMock;
    protected $imageMock;

    public function setUp()
	{
		parent::createApplication();
		$this->modelMock = Mockery::mock('App\Estadio');
		$this->requestMock = Mockery::mock('App\Http\Requests\JugadorRequest');
		$this->imageMock = new UploadedFile('tests/imagen1.jpg','imagen1.jpg','image/jpeg', null, null, true);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearJugadores()
	{
		return array(
			Factory::make('App\Estadio'),
			Factory::make('App\Estadio'),
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
		$this->modelMock->shouldReceive('search')->once()->andReturn($jugadoresPaginados);
		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn($campos);
		$this->app->instance('App\Estadio', $this->modelMock);

		$response = $this->call('GET', '/jugadores', ['keyword' => $keyword, 'column' => $columna]);

		$this->assertViewHas('jugadores', $jugadoresPaginados);
		$this->assertViewHas('searchFields', $campos);
		$this->assertViewHas('keyword', $keyword);
		$this->assertViewHas('column', $columna);
		$this->seePageIs('/jugadores');
	}

	public function test_Index_muestra_mensajes_si_existe_keyword_y_trae_array()
	{
		$keyword = 'Nombre';	
		Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");

		$this->index_trae_arreglo_de_jugadores($keyword);
	}
	
	public function test_Index_no_muestra_mensajes_si_no_existe_keyword_y_trae_array()
	{
		$keyword = '';	
		Flash::shouldReceive('info')->never();

		$this->index_trae_arreglo_de_jugadores($keyword);
	}

	public function test_Index_redirecciona_hacia_Create()
	{
		$this->modelMock->shouldReceive('search')->once()->andReturn($this->crearJugadoresPaginados());
		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn([]);
		$this->app->instance('App\Estadio', $this->modelMock);

		$this->visit('/jugadores');
		$this->click('Agregar un Jugador');
		$this->seePageIs('/jugadores/create');
	}

	public function store_guarda_objeto_y_redirecciona_hacia_index($jugador, $imagen)
	{
		Flash::shouldReceive('success')->once()->with("Jugador creado exitosamente");

		// $this->app->instance('App\Http\Requests\JugadorRequest', $this->requestMock);
		// $this->requestMock->shouldReceive('make')->withAnyArgs()->andReturn('true');
		// $this->requestMock->shouldReceive('all')->withAnyArgs()->andReturn($jugador);
		// $this->requestMock->shouldReceive('file')->withAnyArgs()->andReturn(false);

		$this->app->instance('App\Estadio', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/jugadores', $jugador, [], $imagen);
		$this->assertRedirectedTo('/jugadores');
	}
	
	public function test_Store_sin_imagenes()
	{
		$jugador = Factory::attributesFor(
			'App\Estadio',
			['jug_id' => '','jug_apellido' => 'sas','jug_nombre' => 'sas','jug_apodo' => '','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);  
	
		$this->store_guarda_objeto_y_redirecciona_hacia_index($jugador, array());
	}	

	public function test_Store_con_imagenes()
	{		
		$jugador = Factory::attributesFor(
			'App\Estadio',
			['jug_id' => '','jug_apellido' => 'sas','jug_nombre' => 'sas','jug_apodo' => '','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => $this->imageMock, 'jug_nacionalidad' => '',]
		);  

		$this->modelMock->shouldReceive('procesarImagen')->once();

		$this->store_guarda_objeto_y_redirecciona_hacia_index($jugador, ['jug_foto' => $this->imageMock]);		
	}	

	public function test_Show_devuelve_jugador()
	{
		$jugador = Factory::make('App\Estadio',['jug_foto' => 'https://d1avok0lzls2w.cloudfront.net/img_uploads/changing-urls-0(2).jpg']);

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($jugador);
		$this->app->instance('App\Estadio', $this->modelMock);

		$response = $this->call('GET', '/jugadores/1');
		$this->assertViewHas('jugador', $jugador);
	}

	public function test_Show_redirecciona_hacia_Editar()
	{
		$lugar = Factory::make('App\Lugar', ['lug_id' => 1, 'lug_nombre' => 'foooooooooooo']);
		$jugador = Factory::make('App\Estadio',
			['jug_id' => 1, 'jug_foto' => 'http://lanacion.com.ec/wp-content/uploads/2015/09/onu.jpg','jug_nacionalidad' => 1,  'nacionalidad' => $lugar]
		);
		
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($jugador);
		$this->modelMock->shouldReceive('with->findOrFail')->once()->andReturn($jugador);
		$this->app->instance('App\Estadio', $this->modelMock);

		$response = $this->visit('/jugadores/1');
		$this->press('Editar');
		$this->seePageIs('/jugadores/1/edit');
		$this->see('foooooooooooo');
	}

	public function update_actualiza_registro_y_redirecciona_hacia_Index($jugador, $imagen)
	{
		Flash::shouldReceive('success')->once()->with("Jugador actualizado exitosamente");

		$this->app->instance('App\Estadio', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/jugadores/1', $jugador, [], $imagen);
		$this->assertRedirectedTo('/jugadores');
	}

	public function test_Update_sin_imagenes()
	{
		$jugador= Factory::attributesFor(
			'App\Estadio',
			['jug_id' => '1','jug_apellido' => 'mic','jug_nombre' => 'mic','jug_apodo' => '','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => '','jug_nacionalidad' => '',]
		);

		$this->update_actualiza_registro_y_redirecciona_hacia_Index($jugador, array());
	}

	public function test_Update_con_imagenes()
	{
		$jugador = Factory::attributesFor(
			'App\Estadio',
			['jug_id' => '1','jug_apellido' => 'mic','jug_nombre' => 'mic','jug_apodo' => '','jug_fecha_nacimiento' => '',
			'jug_altura' => '','jug_sitioweb' => '','jug_twitter' => '','jug_foto' => $this->imageMock,'jug_nacionalidad' => '',]
		);

		$this->modelMock->shouldReceive('reemplazarImagen')->once()->andReturn('/nuevo/path');
		$this->update_actualiza_registro_y_redirecciona_hacia_Index($jugador, ['jug_foto' => $this->imageMock]);
	}

	public function destroy_borra_registro()
	{
		Flash::shouldReceive('warning')->once()->with("Jugador borrado exitosamente");

		$this->app->instance('App\Estadio', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		// $this->modelMock->shouldReceive('borrarImagen')->once()->andReturn('true');
		$this->modelMock->shouldReceive('delete')->once()->andReturn('true');
		
		$response = $this->call('DELETE', '/jugadores/1');
		// $this->assertRedirectedTo('/jugadores');
	}

	public function test_Destroy_borra_registro_sin_imagen()
	{
		$this->modelMock->shouldReceive('getPicturePath')->once()->andReturn(null);
		$this->destroy_borra_registro();
	}

	public function test_Destroy_borra_registro_con_imagen()
	{
		$this->modelMock->shouldReceive('getPicturePath')->once()->andReturn('/public/path');
		$this->modelMock->shouldReceive('borrarImagen')->once();
		
		$this->destroy_borra_registro();
	}
}