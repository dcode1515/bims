<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidencyCertificateTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residency_certificate_tbl', function (Blueprint $table) {
             $table->id();

            // Foreign Keys
            $table->unsignedBigInteger('name_requestor')->nullable();
            $table->unsignedBigInteger('purok_id')->nullable();

            // Residency Info
            $table->string('resident_type')->nullable(); // Permanent, Bona Fide, etc.
            $table->date('date_issued')->nullable();
            $table->string('purpose')->nullable();

            // Payment Info
            $table->string('payment_mode')->nullable();
            $table->date('date_paid')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_status')->nullable();

            // Application Status
            $table->string('status')->nullable();

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
        Schema::dropIfExists('residency_certificate_tbl');
    }
}
