<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyHighestEducationInHouseholdMembersTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('household_members_tbl', function (Blueprint $table) {
            //
              $table->string('highest_education')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('household_members_tbl', function (Blueprint $table) {
            //
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
            ])->nullable()->change();
        });
    }
}
