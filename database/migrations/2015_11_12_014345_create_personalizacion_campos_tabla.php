<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalizacionCamposTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalizacion_campos', function (Blueprint $table) {
            $table->increments('pca_id');
            $table->string('pca_nombre', 100);
            $table->string('pca_descripcion', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('personalizacion_campos');
    }
}
