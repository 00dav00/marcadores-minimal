<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleToUsers extends Migration
{
  public function up()
  {
    Schema::table('users', function($table) {
      $table->string('role', 20);
      $table->index('role');
    });
  }

  public function down()
  {
    Schema::table('users', function($table) {
      $table->dropIndex('users_role_index');
      $table->dropColumn('role');
    });
  }
}
