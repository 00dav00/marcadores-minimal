<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJugadoresPartidoEquipoFk extends Migration {

    public function up() {
        Schema::table('partido_jugadores', function(Blueprint $table) {
            $table->integer('eqp_id')->unsigned()->nullable();
        });
    }

    public function down() {
        Schema::table('partido_jugadores', function (Blueprint $table) {
            $table->dropColumn('eqp_id');
        });
    }
}
