<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangayInfoTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangay_info_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('barangay_name');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('region');
            $table->string('barangay_code')->unique();
            $table->string('zip_code', 10);

            $table->string('contact_number', 20)->nullable();
            $table->string('email')->nullable();

            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangay_info_tbl');
    }
}
