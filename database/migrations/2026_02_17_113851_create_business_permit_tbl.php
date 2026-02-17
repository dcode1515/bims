<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessPermitTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_permit_tbl', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('barangay_info_id'); // Reference to barangay info
            $table->unsignedBigInteger('purok_id'); // Reference to purok
            $table->string('name_requestor'); // Name of the requestor
            $table->string('building_permit_no')->unique(); // Building permit number
            $table->date('date_issued'); // Date issued
            $table->text('purpose')->nullable(); // Purpose
            $table->text('case')->nullable(); // Case info
            $table->text('requirements_building')->nullable(); // Requirements for building
            $table->string('mode_of_payment')->nullable(); // Mode of payment
            $table->date('date_paid')->nullable(); // Date paid
            $table->decimal('amount', 12, 2)->nullable(); // Amount paid
            $table->string('status'); // Status
            $table->timestamps(); // Created_at and updated_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_permit_tbl');
    }
}
