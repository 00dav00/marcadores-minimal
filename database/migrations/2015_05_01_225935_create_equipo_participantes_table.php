<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoParticipantesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipos_participantes', function(Blueprint $table)
		{
			$table->integer('eqp_id')->unsigned();
			$table->foreign('eqp_id')->references('eqp_id')->on('equipos');
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
		Schema::drop('equipos_participantes');
	}

}
