<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnTorneoTablePenalizaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penalizaciones_torneo', function(Blueprint $table)
        {
            $table->dropForeign('penalizaciones_torneo_tor_id_foreign');
            $table->dropColumn('tor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penalizaciones_torneo', function(Blueprint $table)
        {
            $table->integer('tor_id')->unsigned()->nullable();;
            $table->foreign('tor_id')->references('tor_id')->on('torneos');
        });
    }
}
