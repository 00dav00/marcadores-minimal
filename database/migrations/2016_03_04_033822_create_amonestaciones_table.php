<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmonestacionesTable extends Migration
{
     public function up() {
        Schema::create('amonestaciones', function(Blueprint $table) {
            $table->increments('amn_id');

            $table->integer('par_id')->unsigned();
            $table->foreign('par_id')->references('par_id')->on('partidos')->onDelete('restrict');

            $table->integer('jug_id')->unsigned();
            $table->foreign('jug_id')->references('jug_id')->on('jugadores')->onDelete('restrict');

            $table->integer('eqp_id')->unsigned();
            $table->foreign('eqp_id')->references('eqp_id')->on('equipos')->onDelete('restrict');

            $table->enum('amn_tipo', ['amarilla', 'roja']);
            $table->integer('amn_minuto');
        });
    }

    public function down() {
        Schema::drop('amonestaciones');
    }
}
