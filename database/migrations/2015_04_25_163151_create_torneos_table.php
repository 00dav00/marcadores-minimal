<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTorneosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('torneos', function(Blueprint $table)
		{
			$table->increments('tor_id');
			$table->string('tor_nombre', 500);
			$table->integer('tor_anio_referencia');
			$table->date('tor_fecha_inicio');
			$table->date('tor_fecha_fin');
			$table->enum('tor_tipo_equipos', ['seleccion', 'profesional', 'amateur', 'evento']);
			$table->integer('tor_numero_equipos');
			$table->integer('lug_id')->unsigned();
			$table->foreign('lug_id')->references('lug_id')->on('lugares');
			$table->integer('ttr_id')->unsigned();
			$table->foreign('ttr_id')->references('ttr_id')->on('tipo_torneos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('torneos');
	}

}
