<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameGroupIdToTravelId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('members', function (Blueprint $table) {
          $table->renameColumn('group_id', 'travel_id');
      });

      Schema::table('expenses', function (Blueprint $table) {
          $table->renameColumn('group_id', 'travel_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('members', function (Blueprint $table) {
          $table->renameColumn('travel_id', 'group_id');
      });

      Schema::table('expenses', function (Blueprint $table) {
          $table->renameColumn('travel_id', 'group_id');
      });
    }
}
