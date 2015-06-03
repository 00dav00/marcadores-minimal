<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPKToPlantillasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('plantillas_torneo', function(Blueprint $table)
		{
			$table->increments('plt_id');
			$table->unique(array('eqp_id','jug_id','tor_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// DB::statement('ALTER TABLE  `plantillas_torneo` DROP PRIMARY KEY');
		Schema::table('plantillas_torneo', function(Blueprint $table)
		{

			$table->dropForeign('plantillas_torneo_tor_id_foreign');
			$table->dropForeign('plantillas_torneo_eqp_id_foreign');
			$table->dropForeign('plantillas_torneo_jug_id_foreign');

			$table->dropUnique('plantillas_torneo_eqp_id_jug_id_tor_id_unique');

			$table->foreign('eqp_id')->references('eqp_id')->on('equipos');
			$table->foreign('jug_id')->references('jug_id')->on('jugadores');
			$table->foreign('tor_id')->references('tor_id')->on('torneos');

	
				
			$table->integer('plt_id')->change();
			$table->dropPrimary('plantillas_torneo_plt_id_primary');
			$table->dropColumn('plt_id');
		});
	}
}
