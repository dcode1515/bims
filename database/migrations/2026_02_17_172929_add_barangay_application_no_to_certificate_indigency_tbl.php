<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBarangayApplicationNoToCertificateIndigencyTbl extends Migration
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
              $table->string('application_no')->nullable()->after('id'); // new application number
           

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
               $table->dropColumn('application_no');
            $table->dropColumn('barangay_info_id');
        });
    }
}
