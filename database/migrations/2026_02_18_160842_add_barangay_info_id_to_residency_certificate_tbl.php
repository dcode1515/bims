<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBarangayInfoIdToResidencyCertificateTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('residency_certificate_tbl', function (Blueprint $table) {
            //
               $table->unsignedBigInteger('barangay_info_id')
                  ->nullable()
                  ->after('application_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('residency_certificate_tbl', function (Blueprint $table) {
            //
              $table->dropColumn('barangay_info_id');
        });
    }
}
