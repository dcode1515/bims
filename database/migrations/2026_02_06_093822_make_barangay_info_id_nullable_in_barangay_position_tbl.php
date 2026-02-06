<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeBarangayInfoIdNullableInBarangayPositionTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangay_position_tbl', function (Blueprint $table) {
            //
             $table->unsignedBigInteger('barangay_info_id')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangay_position_tbl', function (Blueprint $table) {
            //
             $table->unsignedBigInteger('barangay_info_id')->nullable(false)->change();
        });
    }
}
