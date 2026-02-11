<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdMembersTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('household_members_tbl', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('barangay_info_id');
             $table->unsignedBigInteger('household_id');

          $table->boolean('is_head')->default(false);

            // Personal Information
            $table->string('first_name');
            $table->string('middle_initial', 3)->nullable();
            $table->string('last_name');
            $table->enum('extension', ['Jr', 'Sr', 'II', 'III', 'IV'])->nullable();
            $table->enum('sex', ['Male', 'Female']);
            $table->date('birthdate');
            $table->enum('civil_status', [
                'Single',
                'Married',
                'Widowed',
                'Separated',
                'Divorced'
            ]);
            $table->string('relationship')->nullable();

            // Identification & Status
            $table->string('national_id')->nullable();
            $table->enum('voter_status', ['Voter', 'Non-Voter']);
            $table->enum('is_4ps_member', ['Yes', 'No']);
            $table->boolean('is_deceased')->default(false);

            // Education
            $table->enum('highest_education', [
                'No Formal Education',
                'Elementary Level',
                'Elementary Graduate',
                'High School Level',
                'High School Graduate',
                'College Level',
                'College Graduate',
                'Vocational or Tech Course',
                'Post Graduate',
                "Masters Degree",
                'Doctorate Degree'
            ]);

            $table->enum('educational_status', [
                'Not Attending School',
                'Currently Enrolled',
                'Graduated',
                'Dropout',
                'ALS Graduate',
                'ALS Student'
            ]);

            // Employment
            $table->enum('employment_status', ['Employed', 'Unemployed']);
            $table->string('occupation')->nullable();
            $table->enum('nature_of_employment', [
                'Government Employee',
                'Private Employee',
                'Self-Employed',
                'OFW',
                'Casual',
                'Seasonal',
                'Contractual'
            ])->nullable();

            $table->decimal('monthly_income', 12, 2)->nullable();

            // Contact Information
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();

            $table->timestamps();

            // Indexes (for performance)
            $table->index(['last_name', 'first_name']);
            $table->index('voter_status');
            $table->index('is_4ps_member');
            $table->index('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('household_members_tbl');
    }
}
