<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partidos', function(Blueprint $table)
		{
			$table->increments('par_id');

			/**
			 * FALTA LLAVES FORANEAS 
			 * 		FECHA DEL CAMPEONATO 
			 * 		ARBITROS DEL PARTIDO 
			 * */

			$table->integer('par_eqp_local')->unsigned();
			$table->foreign('par_eqp_local')->references('eqp_id')->on('equipos')->onDelete('restrict');

			$table->integer('par_eqp_visitante')->unsigned();
			$table->foreign('par_eqp_visitante')->references('eqp_id')->on('equipos')->onDelete('restrict');

			$table->integer('est_id')->unsigned();
			$table->foreign('est_id')->references('est_id')->on('estadios')->onDelete('restrict');

			$table->integer('fec_id')->unsigned();
			$table->foreign('fec_id')->references('fec_id')->on('fechas')->onDelete('restrict');

			$table->date('par_fecha')->nullable();
			$table->time('par_hora')->nullable();
			$table->integer('par_goles_local')->nullable();
			$table->integer('par_goles_visitante')->nullable();

			$table->string('par_cronica', 200)->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('partidos');
	}

}
