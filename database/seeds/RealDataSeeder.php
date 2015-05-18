<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RealDataSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		// $this->call('UserTableSeeder');
	}

}