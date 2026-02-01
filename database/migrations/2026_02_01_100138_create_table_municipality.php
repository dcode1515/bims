<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMunicipality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_municipality', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('province_id'); // Foreign key reference to table_province
            $table->string('municipality_name'); // Municipality name
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
        Schema::dropIfExists('table_municipality');
    }
}
