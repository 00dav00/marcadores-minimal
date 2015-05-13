<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fases', function(Blueprint $table)
		{
			$table->increments('fas_id');
			$table->string('fas_descripcion', 200);
			$table->integer('tfa_id')->unsigned();
			$table->foreign('tfa_id')->references('tfa_id')->on('tipo_fases');
			$table->integer('tor_id')->unsigned();
			$table->foreign('tor_id')->references('tor_id')->on('torneos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fases');
	}

}
