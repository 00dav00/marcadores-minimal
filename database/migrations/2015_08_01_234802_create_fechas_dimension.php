<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechasDimension extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dim_fechas', function(Blueprint $table)
		{
			$table->increments('dfe_id');

			$table->integer('dfe_torneo_id');
			$table->string('dfe_torneo_nombre', 500);
			$table->integer('dfe_torneo_anio_referencia');
			$table->date('dfe_torneo_fecha_inicio');
			$table->date('dfe_torneo_fecha_fin');
			$table->enum('dfe_torneo_tipo_equipos', ['seleccion', 'profesional', 'amateur', 'evento']);


			$table->integer('dfe_tipo_torneo_id');
			$table->string('dfe_tipo_torneo_nombre', 100);

			$table->integer('dfe_fase_id');
			$table->string('dfe_fase_descripcion', 200);

			$table->integer('dfe_tipo_fase_id');
			$table->string('dfe_tipo_fase_nombre', 100);

			$table->integer('dfe_fecha_id');
			$table->integer('dfe_fecha_numero');
			$table->date('dfe_fecha_fecha_referencia');

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
		Schema::drop('dim_fechas');
	}

}
