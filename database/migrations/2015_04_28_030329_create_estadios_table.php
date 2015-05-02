<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estadios', function(Blueprint $table)
		{
			$table->increments('est_id');
			$table->string('est_nombre',50);
			$table->date('est_fecha_inauguracion')->nullable();
			$table->string('est_foto_por_defecto',200)->nullable();
			$table->integer('est_aforo')->nullable();

			$table->integer('lug_id')->unsigned()->nullable();
			$table->foreign('lug_id')->references('lug_id')->on('lugares')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estadios');
	}

}
