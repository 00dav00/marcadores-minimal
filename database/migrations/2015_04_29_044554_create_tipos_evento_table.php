<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposEventoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipos_evento', function(Blueprint $table)
		{
			$table->increments('tev_id');
			$table->string('tev_nombre',50)->index();
			$table->string('tev_descripcion',200)->nullable();
			$table->string('tev_comentario1',100)->nullable();
			$table->string('tev_comentario2',100)->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tipos_evento');
	}

}
