<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangayOfficialTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangay_official_tbl', function (Blueprint $table) {
           $table->id();

            // Name
            $table->string('first_name');
            $table->string('middle_initial', 5)->nullable();
            $table->string('last_name');
            $table->string('extension', 10)->nullable(); // Jr., Sr., III

            // Position & term
            $table->string('position'); // Captain, Kagawad, etc.
            $table->date('term_start')->nullable();
            $table->date('term_end')->nullable();
            $table->string('term_status'); // Ongoing, Ended, Resigned

            // Contact & address
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            // Status
            $table->string('active'); // Active, Inactive

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
        Schema::dropIfExists('barangay_official_tbl');
    }
}
