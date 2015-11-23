<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalizacionValoresTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalizacion_valores', function (Blueprint $table) {
            $table->increments('pva_id');
            $table->integer('pca_id');
            $table->integer('clt_id')->unsigned();
            $table->foreign('clt_id')->references('clt_id')->on('clientes')->onDelete('restrict');
            $table->string('pva_valor', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('personalizacion_valores');
    }
}
