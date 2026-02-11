<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdLivestocksTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('household_livestocks_tbl', function (Blueprint $table) {
             $table->id();
            $table->integer('household_id'); 
            $table->unsignedBigInteger('barangay_info_id');
            $table->string('type');
            $table->string('category');
            $table->integer('quantity')->default(0);
            $table->string('unit');
            $table->json('details')->nullable();
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
        Schema::dropIfExists('household_livestocks_tbl');
    }
}
