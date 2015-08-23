<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregardimequiposeqpNombreCorto extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dim_equipos', function(Blueprint $table)
		{
			$table->string('deq_nombre_corto',50)->nullable();
			$table->string('deq_abreviatura',10)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('dim_equipos', function (Blueprint $table) {
		    $table->dropColumn('deq_nombre_corto');
		    $table->dropColumn('deq_abreviatura');
		});
	}

}
