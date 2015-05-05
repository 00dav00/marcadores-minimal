<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidoEventosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partido_eventos', function(Blueprint $table)
		{
			$table->increments('pev_id');

			$table->integer('pev_minuto');

			$table->integer('pev_jugador1')->unsigned()->nullable();
			$table->foreign('pev_jugador1')->references('pju_id')->on('partido_jugadores')->onDelete('restrict');

			$table->integer('pev_evento1')->unsigned();
			$table->foreign('pev_evento1')->references('tev_codigo')->on('tipos_evento')->onDelete('restrict');

			$table->integer('pev_jugador2')->unsigned()->nullable();
			$table->foreign('pev_jugador2')->references('pju_id')->on('partido_jugadores')->onDelete('restrict');

			$table->integer('pev_evento2')->unsigned()->nullable();
			$table->foreign('pev_evento2')->references('tev_codigo')->on('tipos_evento')->onDelete('restrict');

			$table->string('pev_metadata',500);
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
		Schema::drop('partido_eventos');
	}

}
