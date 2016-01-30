<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPenalizacionFactResultados extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fact_resultados', function(Blueprint $table)
		{
			$table->integer('penalizacion')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fact_resultados', function (Blueprint $table) {
			$table->dropColumn('penalizacion');
		});
	}

}
