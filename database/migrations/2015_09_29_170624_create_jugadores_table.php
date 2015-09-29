<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJugadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugadores', function(Blueprint $table)
        {
            $table->increments('jug_id');
            $table->string('jug_apellido', 100);
            $table->string('jug_nombre', 100);
            $table->string('jug_apodo', 50)->nullable();
            $table->date('jug_fecha_nacimiento')->nullable();
            $table->integer('jug_altura')->nullable();
            $table->string('jug_sitioweb', 100)->nullable();
            $table->string('jug_twitter', 50)->nullable();
            $table->string('jug_foto', 200)->nullable();
            $table->integer('jug_nacionalidad')->unsigned()->nullable();
            $table->foreign('jug_nacionalidad')->references('lug_id')->on('lugares');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jugadores');
    }
}
