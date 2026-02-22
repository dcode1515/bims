<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameColumnsToIntegerInBlotterCaseRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blotter_case_records', function (Blueprint $table) {
            //
               $table->integer('complainant_name')->change();
            $table->integer('respondent_name')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blotter_case_records', function (Blueprint $table) {
            //
          $table->string('complainant_name')->change();
            $table->string('respondent_name')->change();
            
        });
    }
}
