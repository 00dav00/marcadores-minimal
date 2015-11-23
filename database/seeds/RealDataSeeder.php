<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use database\seeds\TipoFaseTableSeeder;
use database\seeds\TipoEventoTableSeeder;
use database\seeds\TipoTorneoTableSeeder;

class RealDataSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		// $this->call('TipoEventoTableSeeder');
		$this->call('TipoFaseTableSeeder');
		$this->call('TipoTorneoTableSeeder');
		$this->call('ProductosSeeder');
	}

}