<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBarangay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_barangay', function (Blueprint $table) {
             $table->id(); // Primary key
            $table->unsignedBigInteger('municipality_id'); // Foreign key reference to table_municipality
            $table->string('barangay_name'); // Barangay name
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_barangay');
    }
}
