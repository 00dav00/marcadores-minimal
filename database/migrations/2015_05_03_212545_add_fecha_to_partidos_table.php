<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaToPartidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('partidos', function(Blueprint $table)
		{
			$table->integer('fec_id')->unsigned();

			$table->foreign('fec_id')
					->references('fec_id')
					->on('fechas')
					->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('partidos', function(Blueprint $table)
		{
			$table->dropColumn('fec_id');
		});
	}

}
