<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPwdColumnsToHouseholdMembersTbl extends Migration
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
              $table->string('pwd_type')->nullable()->after('isPWD');
            $table->string('pwd_other_specify')->nullable()->after('pwd_type');
            $table->string('pwd_id_number')->nullable()->after('pwd_other_specify');
            $table->string('pwd_cause')->nullable()->after('pwd_id_number');
            $table->string('pwd_cause_other')->nullable()->after('pwd_cause');
            $table->string('pwd_degree')->nullable()->after('pwd_cause_other');
            $table->json('pwd_assistance')->nullable()->after('pwd_degree');
            $table->string('pwd_assistance_other')->nullable()->after('pwd_assistance');
            $table->text('pwd_notes')->nullable()->after('pwd_assistance_other');

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
              $table->dropColumn([
               
                'pwd_type',
                'pwd_other_specify',
                'pwd_id_number',
                'pwd_cause',
                'pwd_cause_other',
                'pwd_degree',
                'pwd_assistance',
                'pwd_assistance_other',
                'pwd_notes'
            ]);
        });
    }
}
