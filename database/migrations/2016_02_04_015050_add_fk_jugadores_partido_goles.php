<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkJugadoresPartidoGoles extends Migration
{
     public function up() {
        Schema::table('partido_goles', function (Blueprint $table) {
            $table->foreign('gol_autor')->references('jug_id')->on('jugadores')->onDelete('restrict');
            $table->foreign('gol_asistencia')->references('jug_id')->on('jugadores')->onDelete('restrict');
        });
    }

    public function down() {
        Schema::table('partido_goles', function(Blueprint $table) {
            $table->dropForeign('partido_goles_gol_autor_foreign');
            $table->dropForeign('partido_goles_gol_asistencia_foreign');
        });
    }
}
