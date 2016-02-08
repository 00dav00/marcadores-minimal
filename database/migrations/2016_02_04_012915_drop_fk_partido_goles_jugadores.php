<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFkPartidoGolesJugadores extends Migration
{
    public function up() {
        Schema::table('partido_goles', function (Blueprint $table) {
            $table->dropForeign('partido_goles_gol_autor_foreign');
            $table->dropForeign('partido_goles_gol_asistencia_foreign');
        });
    }

    public function down() {
        Schema::table('partido_goles', function(Blueprint $table) {
            $table->foreign('gol_autor')->references('pju_id')->on('partido_jugadores')->onDelete('restrict');
            $table->foreign('gol_asistencia')->references('pju_id')->on('partido_jugadores')->onDelete('restrict');
        });
    }
}
