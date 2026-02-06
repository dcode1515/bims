<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToBarangayPositionTbl extends Migration
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
               $table->softDeletes()->after('status'); // adds deleted_at column
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
             $table->dropSoftDeletes();
        });
    }
}
