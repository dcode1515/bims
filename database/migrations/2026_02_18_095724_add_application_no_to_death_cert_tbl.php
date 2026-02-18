<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicationNoToDeathCertTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('death_cert_tbl', function (Blueprint $table) {
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
        Schema::table('death_cert_tbl', function (Blueprint $table) {
            //
               $table->dropColumn('application_no');
        });
    }
}
