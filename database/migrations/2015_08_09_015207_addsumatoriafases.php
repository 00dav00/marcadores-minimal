<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addsumatoriafases extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fases', function(Blueprint $table)
		{
			$table->boolean('fas_acumulada')->default(true);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fases', function (Blueprint $table) {
		    $table->dropColumn('fas_acumulada');
		});
	}

}
