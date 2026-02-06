<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToBarangayCommiteeTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangay_commitee_tbl', function (Blueprint $table) {
            //
                $table->softDeletes(); // adds deleted_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangay_commitee_tbl', function (Blueprint $table) {
            //
              $table->dropSoftDeletes();
        });
    }
}
