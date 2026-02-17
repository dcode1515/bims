<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBusinessPermitTblToBuildingPermitTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_permit_tbl', function (Blueprint $table) {
            //
            Schema::rename('business_permit_tbl', 'building_permit_tbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_permit_tbl', function (Blueprint $table) {
            //
            Schema::rename('building_permit_tbl', 'business_permit_tbl');
        });
    }
}
