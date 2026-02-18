<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameDeceasedToDeathCertTbl extends Migration
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
            $table->unsignedBigInteger('name_deceased')
                  ->nullable()
                  ->after('name_requestor');
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
                 $table->dropColumn('name_deceased');
        });
    }
}
