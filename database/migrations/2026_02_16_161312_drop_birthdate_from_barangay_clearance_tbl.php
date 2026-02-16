<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBirthdateFromBarangayClearanceTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangay_clearance_tbl', function (Blueprint $table) {
            //
              $table->dropColumn('birthdate');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangay_clearance_tbl', function (Blueprint $table) {
            //
             $table->date('birthdate')->nullable()->after('name_requestor');
        });
    }
}
