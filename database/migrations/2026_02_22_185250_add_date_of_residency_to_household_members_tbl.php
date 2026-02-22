<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateOfResidencyToHouseholdMembersTbl extends Migration
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
             $table->date('date_of_residency')->nullable()->after('is_head'); 
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
               $table->dropColumn('date_of_residency');
        });
    }
}
