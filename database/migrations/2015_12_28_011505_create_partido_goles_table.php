<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidoGolesTable extends Migration
{
    public function up()
    {
        Schema::create('partido_goles', function(Blueprint $table)
        {
            $table->increments('gol_id');

            $table->integer('gol_minuto');
            $table->boolean('gol_auto')->default(false);
            $table->enum('gol_jugada', ['jugada','esquina','contra','libre','penal','otro'])
                    ->nullable();
            $table->enum('gol_ejecucion', ['disparo','cabeza','muslo','pecho','chilena','tijera','rebote','otro'])
                    ->nullable();

            $table->integer('gol_autor')->unsigned();
            $table->foreign('gol_autor')->references('pju_id')->on('partido_jugadores')->onDelete('restrict');

            $table->integer('gol_asistencia')->unsigned()->nullable();
            $table->foreign('gol_asistencia')->references('pju_id')->on('partido_jugadores')->onDelete('restrict');

        });
    }

    public function down()
    {
        Schema::drop('partido_goles');
    }
}
