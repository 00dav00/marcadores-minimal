<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipos', function(Blueprint $table)
		{
			$table->increments('eqp_id');
			$table->string('eqp_nombre', 100);
			$table->date('eqp_fecha_fundacion')->nullable();
			$table->string('eqp_escudo', 200);
			$table->string('eqp_twitter',50)->nullable();
			$table->string('eqp_facebook',50)->nullable();
			$table->string('eqp_sitioweb', 200)->nullable();
			$table->enum('eqp_tipo', ['seleccion', 'profesional', 'amateur']);
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
		Schema::drop('equipos');
	}

}
