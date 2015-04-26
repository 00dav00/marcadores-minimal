<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJugadorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jugadores', function(Blueprint $table)
		{
			$table->increments('jug_id');
			$table->string('jug_apellido', 100);
			$table->string('jug_nombre', 100);
			$table->string('jug_apodo', 50);
			$table->date('jug_fecha_nacimiento');
			$table->integer('jug_altura')->nullable();
			$table->string('jug_sitioweb', 100);
			$table->string('jug_twitter', 50);
			$table->string('jug_foto', 200);
			$table->integer('lug_id')->unsigned();
			$table->foreign('lug_id')->references('lug_id')->on('lugares');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jugadores');
	}

}
