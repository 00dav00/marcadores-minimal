<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartidoFkEquipoFkPartidoGoles extends Migration
{
    public function up() {
        Schema::table('partido_goles', function (Blueprint $table) {
            $table->integer('par_id')->unsigned();
            $table->foreign('par_id')->references('par_id')->on('partidos')->onDelete('restrict');
            $table->integer('eqp_id')->unsigned();
            $table->foreign('eqp_id')->references('eqp_id')->on('equipos')->onDelete('restrict');
        });
    }

    public function down() {
        Schema::table('partido_goles', function(Blueprint $table) {
            $table->dropForeign('partido_goles_par_id_foreign');
            $table->dropColumn('par_id');
            $table->dropForeign('partido_goles_eqp_id_foreign');
            $table->dropColumn('eqp_id');
        });
    }
}
