<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMiddleNameToHouseholdMembersTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('household_members_tbl', function (Blueprint $table) {
            //
                $table->renameColumn('middleInitial', 'middle_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('household_members_tbl', function (Blueprint $table) {
            //
              $table->renameColumn('middle_name', 'middleInitial');
        });
    }
}
