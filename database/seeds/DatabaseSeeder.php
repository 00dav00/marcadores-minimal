<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use database\seeds\FakeDataTableSeeder;
use database\seeds\RealDataSeeder;

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

		$this->call('FakeDataTableSeeder');
	}

}
