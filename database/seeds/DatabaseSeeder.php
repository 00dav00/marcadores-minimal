<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use database\seeds\FakeDataTableSeeder;
use database\seeds\RealDataSeeder;
use database\seeds\ClienteTableSeeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('RealDataSeeder');

		//$this->call('FakeDataTableSeeder');
		//$this->call(ClienteTableSeeder::class);
		$this->call(PersonalizacionCamposSeeder::class);
		$this->call(ProductosSeeder::class);

    	Model::reguard();
	}

}