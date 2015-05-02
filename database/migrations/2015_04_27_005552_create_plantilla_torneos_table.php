<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillaTorneosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plantillas_torneo', function(Blueprint $table)
		{
			$table->integer('plt_numero_camiseta');
			$table->integer('eqp_id')->unsigned();
			$table->foreign('eqp_id')->references('eqp_id')->on('equipos');
			$table->integer('jug_id')->unsigned();
			$table->foreign('jug_id')->references('jug_id')->on('jugadores');
			$table->integer('tor_id')->unsigned();
			$table->foreign('tor_id')->references('tor_id')->on('torneos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plantillas_torneo');
	}

}
