<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateIndigencyTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_indigency_tbl', function (Blueprint $table) {
              $table->id(); // auto-increment primary key
            $table->string('name_requestor')->nullable();
            $table->string('purok_id')->nullable();
            $table->date('date_issued')->nullable();
            $table->string('purpose')->nullable();
            $table->string('payment_mode')->nullable();
            $table->date('date_paid')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('payment_status');
            $table->string('status')->nullable();// you can adjust default
            $table->timestamps(); // includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificate_indigency_tbl');
    }
}
