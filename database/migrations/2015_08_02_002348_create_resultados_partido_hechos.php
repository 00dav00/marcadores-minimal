<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultadosPartidoHechos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fact_resultados', function(Blueprint $table)
		{
			$table->integer('fecha_fk')->unsigned();
			$table->integer('equipo_fk')->unsigned();
			$table->integer('equipo_rival_fk')->unsigned();

			$table->integer('goles_favor');
			$table->integer('goles_contra');
			$table->integer('puntos');

			$table->foreign('fecha_fk')->references('dfe_id')->on('dim_fechas');
			$table->foreign('equipo_fk')->references('deq_id')->on('dim_equipos');
			$table->foreign('equipo_rival_fk')->references('deq_id')->on('dim_equipos');


			$table->unique(array('fecha_fk', 'equipo_fk', 'equipo_rival_fk'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fact_resultados');
	}

}
