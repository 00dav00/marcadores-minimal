<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposDimension extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dim_equipos', function(Blueprint $table)
		{
			$table->increments('deq_id');

			$table->integer('deq_equipo_id');
			$table->string('deq_equipo_nombre', 100);
			$table->enum('deq_equipo_tipo', ['seleccion', 'profesional', 'amateur']);

			$table->date('scd_valido_inicio');
			$table->date('scd_valido_fin')->nullable();
			$table->string('scd_version',20)->nullable();
			$table->boolean('scd_activo')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dim_equipos');
	}

}
