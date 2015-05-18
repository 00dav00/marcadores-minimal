<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

use App\Jugador;
use App\Torneo;
use App\Equipo;

class FakeDataTableSeeder extends Seeder
{

	public function run()
	{

		// Jugador::truncate();
		// Equipo::truncate();
		// Torneo::truncate();

		// TestDummy::times(1000)->create('App\Jugador');
		// TestDummy::times(400)->create('App\Equipo');
		// TestDummy::times(100)->create('App\Torneo');

		TestDummy::times(100)->create('App\Estadio');

	}
}
