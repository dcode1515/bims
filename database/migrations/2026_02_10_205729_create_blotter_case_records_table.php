<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlotterCaseRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blotter_case_records', function (Blueprint $table) {
   $table->id();

            // Case Information
            $table->string('case_number')->unique();
            $table->enum('case_type', [
                'CICL',
                'CAR',
                'Dispute',
                'Criminal',
                'Civil',
                'Other'
            ]);

            // Complainant Information
            $table->string('complainant_name');
            $table->string('complainant_contact')->nullable();
            $table->text('complainant_address')->nullable();

            // Respondent Information
            $table->string('respondent_name');
            $table->string('respondent_contact')->nullable();
            $table->text('respondent_address')->nullable();

            // Case Details
            $table->date('date_filed');
            $table->enum('status', [
                'Pending',
                'Ongoing',
                'Settled',
                'Dismissed',
                'Archived'
            ])->default('Pending');

            // Actions and Hearings
            $table->text('actions_taken')->nullable();
            $table->date('hearing_date')->nullable();
            $table->time('hearing_time')->nullable();
            $table->string('hearing_location')->nullable();

            // System fields
            $table->timestamps();
            $table->softDeletes(); // for archiving records safely
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blotter_case_records');
    }
}
