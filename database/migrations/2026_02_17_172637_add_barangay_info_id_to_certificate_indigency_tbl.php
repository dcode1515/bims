<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBarangayInfoIdToCertificateIndigencyTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificate_indigency_tbl', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('barangay_info_id')->nullable()->after('purok_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificate_indigency_tbl', function (Blueprint $table) {
            //
              $table->dropColumn('barangay_info_id');
        });
    }
}
