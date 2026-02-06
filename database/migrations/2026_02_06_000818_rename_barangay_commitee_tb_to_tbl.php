<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBarangayCommiteeTbToTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl', function (Blueprint $table) {
            //
              Schema::rename('barangay_commitee_tb', 'barangay_commitee_tbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl', function (Blueprint $table) {
            //
            Schema::rename('barangay_commitee_tbl', 'barangay_commitee_tb');
        });
    }
}
