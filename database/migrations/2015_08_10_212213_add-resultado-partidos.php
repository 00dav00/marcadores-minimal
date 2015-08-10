<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResultadoPartidos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('partidos', function(Blueprint $table)
		{
			$table->integer('goles_visitante')->nullable();
			$table->integer('goles_local')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('partidos', function (Blueprint $table) {
		    $table->dropColumn('goles_visitante');
		    $table->dropColumn('goles_local');
		});
	}

}
