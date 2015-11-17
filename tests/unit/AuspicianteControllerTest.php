<?php

use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class AuspicianteControllerTest extends TestCase
{
	use DatabaseTransactions;
    use WithoutMiddleware;

    protected $modelMock;
    protected $requestMock;
    protected $imageMock;

    public function setUp()
	{
		parent::createApplication();
		$this->modelMock = Mockery::mock('App\Auspiciante');
		$this->requestMock = Mockery::mock('App\Http\Requests\AuspicianteRequest');
		$this->imageMock = new UploadedFile('tests/imagen1.jpg','imagen1.jpg','image/jpeg', null, null, true);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	protected function crearAuspiciantes()
	{
		return array(
			Factory::make('App\Auspiciante'),
		);
	}

	protected function crearAuspiciantesPaginados()
	{
		return new Paginator($this->crearAuspiciantes(), 5);
	}

	public function index_trae_arreglo_de_auspiciantes($keyword)
	{
		$campos = array('campo' => 'Nombre');
		$columna = 'Nombre';
		$auspiciantesPaginados = $this->crearAuspiciantesPaginados();

		$this->modelMock->shouldReceive('search')->once()->andReturn($auspiciantesPaginados);
		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn($campos);
		$this->app->instance('App\Auspiciante', $this->modelMock);

		$response = $this->call('GET', '/auspiciantes', ['keyword' => $keyword, 'column' => $columna]);

		$this->assertViewHas('auspiciantes', $auspiciantesPaginados);
		$this->assertViewHas('searchFields', $campos);
		$this->assertViewHas('keyword', $keyword);
		$this->assertViewHas('column', $columna);
		$this->seePageIs('/auspiciantes');
	}

    public function test_mostrar_index()
    {
    	$keyword = '';	
		
		Flash::shouldReceive('info')->never();

		$this->index_trae_arreglo_de_auspiciantes($keyword);
    }

    public function test_Index_muestra_mensajes_si_existe_keyword_y_trae_array()
	{
		$keyword = 'Nombre';	
		Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");

		$this->index_trae_arreglo_de_auspiciantes($keyword);
	}

	public function test_Index_redirecciona_hacia_Create()
	{
		$this->modelMock->shouldReceive('search')->once()->andReturn($this->crearAuspiciantesPaginados());
		$this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn([]);
		$this->app->instance('App\Auspiciante', $this->modelMock);

		$this->visit('/auspiciantes');
		$this->click('Agregar un Auspiciante');
		$this->seePageIs('/auspiciantes/create');
	}

	public function store_guarda_objeto_y_redirecciona_hacia_index($auspiciante, $imagen)
	{
		Flash::shouldReceive('success')->once()->with("Auspiciante creado exitosamente");

		$this->app->instance('App\Auspiciante', $this->modelMock);
		$this->modelMock->shouldReceive('create')->once()->andReturn('true');
		
		$response = $this->call('POST', '/auspiciantes', $auspiciante, [], $imagen);
		$this->assertRedirectedTo('/auspiciantes');
	}	

	public function test_Store_con_imagenes()
	{		
		$auspiciante = Factory::attributesFor(
			'App\Auspiciante',
			[
                'aus_nombre' => 'asdf',
                'aus_sitioweb' => '',
                'aus_imagen' => $this->imageMock
            ]
		); 

		$this->modelMock->shouldReceive('procesarImagen')->once();

		$this->store_guarda_objeto_y_redirecciona_hacia_index($auspiciante, ['aus_imagen' => $this->imageMock]);		
	}

	public function test_Show_devuelve_auspiciante()
	{
		$auspiciante = Factory::make(
			'App\Auspiciante',
			[
				'aus_id' => 1,
                'aus_nombre' => 'asdf',
                'aus_sitioweb' => '',
                'aus_imagen' => 'http://lanacion.com.ec/wp-content/uploads/2015/09/onu.jpg'
            ]
		);

		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($auspiciante);
		$this->app->instance('App\Auspiciante', $this->modelMock);

		$response = $this->call('GET', '/auspiciantes/1');
		$this->assertViewHas('auspiciante', $auspiciante);
	}

	public function test_Show_redirecciona_hacia_Editar()
	{
		$auspiciante = Factory::make(
			'App\Auspiciante',
			[
				'aus_id' => 1,
                'aus_nombre' => 'asdf',
                'aus_sitioweb' => '',
                'aus_imagen' => 'http://lanacion.com.ec/wp-content/uploads/2015/09/onu.jpg'
            ]
		);
		
		$this->modelMock->shouldReceive('findOrFail')->twice()->andReturn($auspiciante);
		$this->app->instance('App\Auspiciante', $this->modelMock);

		$response = $this->visit('/auspiciantes/1');
		$this->press('Editar');
		$this->seePageIs('/auspiciantes/1/edit');
		$this->see('asdf');
	}

	public function update_actualiza_registro_y_redirecciona_hacia_Index($auspiciante, $imagen)
	{
		Flash::shouldReceive('success')->once()->with("Auspiciante actualizado exitosamente");

		$this->app->instance('App\Auspiciante', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('update')->once()->andReturn('true');
		
		$response = $this->call('PATCH', '/auspiciantes/1', $auspiciante, [], $imagen);
		$this->assertRedirectedTo('/auspiciantes');
	}

	public function test_Update_con_imagenes()
	{
		$auspiciante = Factory::attributesFor(
			'App\Auspiciante',
			[
                'aus_nombre' => 'asdf',
                'aus_sitioweb' => '',
                'aus_imagen' => $this->imageMock
            ]
		);

		$this->modelMock->shouldReceive('reemplazarImagen')->once()->andReturn('/nuevo/path');
		$this->update_actualiza_registro_y_redirecciona_hacia_Index($auspiciante, ['aus_imagen' => $this->imageMock]);
	}

	public function destroy_borra_registro()
	{
		Flash::shouldReceive('warning')->once()->with("Auspiciante borrado exitosamente");

		$this->app->instance('App\Auspiciante', $this->modelMock);
		$this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
		$this->modelMock->shouldReceive('delete')->once()->andReturn('true');
 		
		$response = $this->call('DELETE', '/auspiciantes/1');
		$this->assertRedirectedTo('/auspiciantes');
	}

	public function test_Destroy_borra_registro_con_imagen()
	{
		$this->modelMock->shouldReceive('getPicturePath')->once()->andReturn('/public/path');
		$this->modelMock->shouldReceive('borrarImagen')->once();
		
		$this->destroy_borra_registro();
	}
}