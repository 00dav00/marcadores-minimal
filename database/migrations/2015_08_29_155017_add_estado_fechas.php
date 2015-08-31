<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoFechas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fechas', function(Blueprint $table)
		{
			$table->enum('fec_estado', ['jugada', 'no_jugada', 'en_juego', 'suspendida'])->default('no_jugada');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fechas', function (Blueprint $table) {
			$table->dropColumn('fec_estado');
		});
	}

}
