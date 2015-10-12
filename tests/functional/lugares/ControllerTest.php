<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ControllerTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    protected $mock;

    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock('App\Lugar');
    }

	public function tearDown()
	{
		Mockery::close();
		parent::tearDown();
	}

  //   public function testLugaresIndex()
  //   {

  //   	$this->mock
		// 	->shouldReceive('search')
		// 	->once()
		// 	->andReturn([]);

		// $this->mock
		// 	->shouldReceive('getSearchFields')
		// 	->once()
		// 	->andReturn(['lug_abreviatura' => 'Abreviatura', 'lug_nombre' => 'Nombre']);

		// $this->app->instance('App\Lugar', $this->mock);

  //   	$response = $this->call('GET', '/lugares');

  //   	$this->assertEquals(200, $response->status());

  //   	$this->assertViewHas('lugares');
  //   }

    public function testLugaresCreate()
    {
    	$response = $this->call('GET', '/lugares/create');

    	$this->assertEquals(200, $response->status());
    }

}