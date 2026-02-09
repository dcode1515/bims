<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBarangayInfoIdToBarangayOfficialTbl extends Migration
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
               $table->unsignedBigInteger('barangay_info_id')->after('id');
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
             Schema::table('barangay_official_tbl', function (Blueprint $table) {
         
             $table->dropColumn('barangay_info_id');
        });
        });
    }
}
