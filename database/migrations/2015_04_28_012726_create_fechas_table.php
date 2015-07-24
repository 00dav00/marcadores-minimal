<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fechas', function(Blueprint $table)
		{
			$table->increments('fec_id');
			$table->integer('fec_numero');
			$table->date('fec_fecha_referencia');
			$table->integer('fas_id')->unsigned();
			$table->foreign('fas_id')->references('fas_id')->on('fases')->onDelete('cascade');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fechas');
	}

}
