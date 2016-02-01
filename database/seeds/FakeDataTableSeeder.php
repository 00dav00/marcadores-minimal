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
		
		$this->call(UsersTableSeeder::class);
		//$this->call(JugadoresTableSeeder::class);
		$this->call(EquiposTableSeeder::class);
		$this->call(ClienteTableSeeder::class);

	}
}
