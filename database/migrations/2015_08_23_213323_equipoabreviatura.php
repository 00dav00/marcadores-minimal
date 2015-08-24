<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Equipoabreviatura extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('equipos', function(Blueprint $table)
		{
			$table->string('eqp_nombre_corto',50)->nullable();
			$table->string('eqp_abreviatura',10)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('equipos', function (Blueprint $table) {
		    $table->dropColumn('eqp_nombre_corto');
		    $table->dropColumn('eqp_abreviatura');
		});
	}

}
