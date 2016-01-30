<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPenalizacionesPrimaryKeyColumn extends Migration
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
            $table->increments('ptr_id');
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
            // $table->dropPrimary('PRIMARY');
            $table->dropColumn('ptr_id');
        });
    }
}
