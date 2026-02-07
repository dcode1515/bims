<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBarangayInfoTableColumnsIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangay_info_tbl', function (Blueprint $table) {
            //

            $table->renameColumn('region', 'region_id');
            $table->renameColumn('province', 'province_id');
            $table->renameColumn('municipality', 'municipality_id');
            $table->renameColumn('barangay', 'barangay_id');
        });
          Schema::table('barangay_info_tbl', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->change();
            $table->unsignedBigInteger('province_id')->change();
            $table->unsignedBigInteger('municipality_id')->change();
            $table->unsignedBigInteger('barangay_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('barangay_info_tbl', function (Blueprint $table) {
            $table->string('region_id')->change();
            $table->string('province_id')->change();
            $table->string('municipality_id')->change();
            $table->string('barangay_id')->change();
        });

        // Then rename back
        Schema::table('barangay_info_tbl', function (Blueprint $table) {
            $table->renameColumn('region_id', 'region');
            $table->renameColumn('province_id', 'province');
            $table->renameColumn('municipality_id', 'municipality');
            $table->renameColumn('barangay_id', 'barangay');
        });
    }
}
