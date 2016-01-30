<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuitarFechaReferenciaFechas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('fechas', function (Blueprint $table) {
		    $table->dropColumn('fec_fecha_referencia');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fechas', function(Blueprint $table)
		{
			$table->date('fec_fecha_referencia');
		});
	}

}
