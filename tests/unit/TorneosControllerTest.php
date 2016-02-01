<?php

use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Way\Tests\Factory;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class TorneosControllerTest extends TestCase
{   
    use WithoutMiddleware;

    protected $modelMock;
    protected $requestMock;

    public function setUp()
    {
        parent::createApplication();
        $this->modelMock = Mockery::mock('App\Torneo');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    protected function crearTorneos()
    {
        factory(App\Torneo::class, 10)->make();
    }

    protected function crearTorneosPaginados()
    {
        return new Paginator($this->crearTorneos(), 5);
    }

    public function index_trae_arreglo_de_torneos($keyword)
    {
        $campos = array('campo' => 'Nombre');
        $columna = 'Nombre';
        $torneosPaginados = $this->creartorneosPaginados();

        $this->modelMock->shouldReceive('search')->once()->andReturn($torneosPaginados);
        $this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn($campos);
        $this->app->instance('App\Torneo', $this->modelMock);

        $response = $this->call('GET', '/torneos', ['keyword' => $keyword, 'column' => $columna]);

        $this->assertViewHas('torneos', $torneosPaginados);
        $this->assertViewHas('searchFields', $campos);
        $this->assertViewHas('keyword', $keyword);
        $this->assertViewHas('column', $columna);
        $this->seePageIs('/torneos');
    }

    public function test_Index_muestra_mensajes_si_existe_keyword_y_trae_array()
    {
        $keyword = 'Nombre';    
        Flash::shouldReceive('info')->once()->with("Resultados de la búsqueda: $keyword");

        $this->index_trae_arreglo_de_torneos($keyword);
    }

    public function test_Index_no_muestra_mensajes_si_no_existe_keyword_y_trae_array()
    {
        $keyword = '';
        Flash::shouldReceive('info')->never();

        $this->index_trae_arreglo_de_torneos($keyword);
    }

    public function test_Index_redirecciona_hacia_Create()
    {

        $this->modelMock->shouldReceive('search')->once()->andReturn($this->creartorneosPaginados());
        $this->modelMock->shouldReceive('getAttribute')->with('searchFields')->andReturn([]);
        $this->app->instance('App\Torneo', $this->modelMock);

        $this->visit('/torneos');
        $this->click('Agregar un torneo');
        $this->seePageIs('/torneos/create');
    }

    public function test_Store_guarda_objeto_y_redirecciona_hacia_index()
    {
        $torneo = factory(App\Torneo::class)->make();

        Flash::shouldReceive('success')->once()->with("Torneo creado exitosamente");

        $this->app->instance('App\Torneo', $this->modelMock);
        $this->modelMock->shouldReceive('create')->once();
        
        $response = $this->call('POST', '/torneos', $torneo->attributesToArray());
        $this->assertRedirectedTo('/torneos');
    }

    public function test_Show_devuelve_torneo()
    {
        $torneo = factory(App\Torneo::class)->make();

        $this->modelMock->shouldReceive('with->findOrFail')->once()->andReturn($torneo);
        $this->app->instance('App\Torneo', $this->modelMock);

        $response = $this->call('GET', '/torneos/1');
        $this->assertViewHas('torneo', $torneo);
    }

    public function test_Show_redirecciona_hacia_Editar()
    {
        $torneo = factory(App\Torneo::class)->make();
        $torneo->tor_id = 1;
        
        $this->modelMock->shouldReceive('with->findOrFail')->times(2)->andReturn($torneo);
        $this->app->instance('App\Torneo', $this->modelMock);

        $response = $this->visit('/torneos/1');
        $this->press('Editar');
        $this->seePageIs('/torneos/1/edit');
        $this->see($torneo->tor_nombre);
    }

    public function test_update_actualiza_registro_y_redirecciona_hacia_Index()
    {
        $torneo = factory(App\Torneo::class)->make();

        Flash::shouldReceive('success')->once()->with("Torneo actualizado exitosamente");

        $this->app->instance('App\Torneo', $this->modelMock);
        $this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
        $this->modelMock->shouldReceive('update')->once()->andReturn('true');
        
        $response = $this->call('PATCH', '/torneos/1', $torneo->attributesToArray());
        $this->assertRedirectedTo('/torneos');
    }

    public function test_Destroy_borra_registro()
    {
        Flash::shouldReceive('warning')->once()->with("Torneo borrado exitosamente");

        $this->app->instance('App\Torneo', $this->modelMock);
        $this->modelMock->shouldReceive('findOrFail')->once()->andReturn($this->modelMock);
        $this->modelMock->shouldReceive('delete')->once();
        
        $response = $this->call('DELETE', '/torneos/1');
        $this->assertRedirectedTo('/torneos');
    }
}