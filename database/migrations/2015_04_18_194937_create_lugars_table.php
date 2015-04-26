<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLugarsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lugares', function(Blueprint $table)
		{
			$table->increments('lug_id');
			$table->string('lug_abreviatura', 10);
			$table->string('lug_nombre', 100);
			$table->enum('lug_tipo', ['continente', 'pais', 'provincia', 'ciudad']);
			$table->integer('parent_lug_id')->unsigned()->nullable();
			$table->foreign('parent_lug_id')->references('lug_id')->on('lugares')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lugares');
	}

}
