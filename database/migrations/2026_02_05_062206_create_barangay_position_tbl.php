<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangayPositionTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangay_position_tbl', function (Blueprint $table) {
           $table->id();

            // Foreign key to barangay_info table
            $table->unsignedBigInteger('barangay_info_id');

            $table->string('position'); // e.g., Captain, Kagawad, SK Kagawad


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangay_position_tbl');
    }
}
