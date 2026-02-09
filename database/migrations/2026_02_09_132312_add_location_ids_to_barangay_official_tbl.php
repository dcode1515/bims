<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationIdsToBarangayOfficialTbl extends Migration
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
              $table->unsignedBigInteger('region_id')->after('id');
            $table->unsignedBigInteger('province_id')->after('region_id');
            $table->unsignedBigInteger('municipality_id')->after('province_id');
            $table->unsignedBigInteger('barangay_id')->after('municipality_id');

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
              $table->dropColumn([
                'region_id',
                'province_id',
                'municipality_id',
                'barangay_id',
            ]);
        });
    }
}
