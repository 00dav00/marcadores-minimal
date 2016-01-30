<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenalizaciones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('penalizaciones_torneo', function(Blueprint $table)
		{
			$table->integer('fas_id')->unsigned();
			$table->foreign('fas_id')->references('fas_id')->on('fases');
			$table->integer('tor_id')->unsigned();
			$table->foreign('tor_id')->references('tor_id')->on('torneos');
			$table->integer('eqp_id')->unsigned();
			$table->foreign('eqp_id')->references('eqp_id')->on('equipos');
			$table->integer('ptr_puntos');
			$table->string('ptr_motivo', 200)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('penalizaciones_torneo');
	}

}
