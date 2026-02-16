<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangayClearanceTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangay_clearance_tbl', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('barangay_info_id');
            $table->string('file_name');

            $table->timestamps();      // created_at & updated_at
            $table->softDeletes();     // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangay_clearance_tbl');
    }
}
