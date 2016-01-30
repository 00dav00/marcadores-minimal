<?php

// use Session;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	protected $baseUrl = 'http://localhost';

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */

	function __construct()
    {
        parent::setUp();
		// Session::start();
  //       $this->beTheUser();
    }

    private function beTheUser(){
        $this->be(App\User::all()->first());
    }

	public function createApplication()
	{

		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

	public function tearDown()
	{
		// $this->flushSession();
		parent::tearDown();
	}
}
