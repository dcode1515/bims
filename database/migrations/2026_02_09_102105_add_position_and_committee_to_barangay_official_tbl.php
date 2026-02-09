<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionAndCommitteeToBarangayOfficialTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangay_official_tbl', function (Blueprint $table) {
            //
             $table->unsignedBigInteger('position_id')->after('id');
            $table->unsignedBigInteger('committee_id')->after('position_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangay_official_tbl', function (Blueprint $table) {
            //
               $table->dropColumn(['position_id', 'committee_id']);
        });
    }
}
