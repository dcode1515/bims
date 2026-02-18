<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicationNoToResidencyCertificateTbl extends Migration
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
              $table->string('application_no')
                  ->unique()
                  ->after('id');
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
             $table->dropColumn('application_no');
        });
    }
}
