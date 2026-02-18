<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeathCertTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('death_cert_tbl', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('barangay_info_id');
            $table->unsignedBigInteger('purok_id');

            $table->date('date_issued')->nullable();
            $table->date('date_of_death');
            $table->string('place_of_death');

            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();

            $table->text('reason')->nullable();

            $table->string('status')->default('pending');

            $table->string('payment_mode')->nullable();
            $table->date('date_paid')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_status')->default('unpaid');

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
        Schema::dropIfExists('death_cert_tbl');
    }
}
