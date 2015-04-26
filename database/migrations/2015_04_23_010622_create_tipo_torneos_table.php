<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoTorneosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_torneos', function(Blueprint $table)
		{
			$table->increments('ttr_codigo');
			$table->string('ttr_nombre', 100);
			$table->string('ttr_descripcion', 200);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tipo_torneos');
	}

}
