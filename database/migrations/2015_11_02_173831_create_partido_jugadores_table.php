<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidoJugadoresTable extends Migration {

    public function up() {
        
        Schema::create('partido_jugadores', function(Blueprint $table) {
            $table->increments('pju_id');

            $table->integer('par_id')->unsigned();
            $table->foreign('par_id')->references('par_id')->on('partidos')->onDelete('restrict');

            $table->integer('jug_id')->unsigned();
            $table->foreign('jug_id')->references('jug_id')->on('jugadores')->onDelete('restrict');

            $table->integer('pju_minuto_ingreso')->default(0);
            $table->integer('pju_minuto_salida')->nullable();

            $table->integer('pju_reemplazo_de')->unsigned()->nullable();
            $table->foreign('pju_reemplazo_de')->references('pju_id')->on('partido_jugadores')->onDelete('restrict');

            $table->boolean('pju_amarilla')->default(false);
            $table->boolean('pju_doble_amarilla')->default(false);
            $table->boolean('pju_roja')->default(false);
            $table->integer('pju_numero_camiseta')->default(0);
            $table->boolean('pju_juvenil')->default(false);

            /**
             * 
             *  FALTA CLAVE FORANEA PARA INDICAR POSICION DEL JUGADOR EN EL PARTIDO
             * 
             */
        });
    }

    public function down() {
        Schema::drop('partido_jugadores');
    }
}
