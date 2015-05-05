<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidoJugadoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partido_jugadores', function(Blueprint $table)
		{
			$table->increments('pju_id');

			$table->integer('par_id')->unsigned();
			$table->foreign('par_id')->references('par_id')->on('partidos')->onDelete('restrict');

			$table->integer('jug_id')->unsigned();
			$table->foreign('jug_id')->references('jug_id')->on('jugadores')->onDelete('restrict');

			$table->integer('pju_minuto_ingreso')->default(0);

			$table->integer('pju_reemplazo')->unsigned()->nullable();
			$table->foreign('pju_reemplazo')->references('pju_id')->on('partido_jugadores')->onDelete('set null');

			$table->boolean('pju_amarilla')->default(false);
			$table->boolean('pju_doble_amarilla')->default(false);
			$table->boolean('pju_roja')->default(false);
			$table->integer('pju_numero_camiseta')->default(0);
			$table->boolean('pju_juvenil')->default(false);

			/**
			 * 
			 * 	FALTA CLAVE FORANEA PARA INDICAR POSICION DEL JUGADOR EN EL PARTIDO
			 * 
			 */
			// $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('partido_jugadores');
	}

}
