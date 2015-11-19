<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuspiciantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auspiciantes', function (Blueprint $table) {
            $table->increments('aus_id');
            $table->string('aus_nombre', 100);
            $table->string('aus_sitioweb', 200)->nullable();
            $table->string('aus_imagen', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('auspiciantes');
    }
}
