<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermAndStatusToBarangayPositionTbl extends Migration
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
             $table->year('term_start')->nullable()->after('position'); // start year
            $table->year('term_end')->nullable()->after('term_start'); // end year
            $table->string('status')->default('Active')->after('term_end'); // Active / Inactive

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
              $table->dropColumn(['term_start', 'term_end', 'status']);
        });
    }
}
