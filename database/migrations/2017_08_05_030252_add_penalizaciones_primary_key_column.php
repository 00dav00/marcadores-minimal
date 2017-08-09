<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPenalizacionesPrimaryKeyColumn extends Migration
{
  public function up()
  {
      Schema::table('penalizaciones_torneo', function(Blueprint $table) {
          $table->increments('ptr_id');
      });
  }

  public function down()
  {
      Schema::table('penalizaciones_torneo', function(Blueprint $table) {
          $table->dropColumn('ptr_id');
      });
  }
}
