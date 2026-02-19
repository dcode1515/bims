<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEncodedIdToHouseholdMembersTbl extends Migration
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
              $table->string('encoded_id')->nullable()->after('id');
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
              $table->dropColumn('encoded_id');
        });
    }
}
