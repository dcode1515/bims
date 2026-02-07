<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermFieldsToPurokTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purok_tbl', function (Blueprint $table) {
            //
              $table->date('term_start_date')->nullable()->after('contact_number');
            $table->date('term_end_date')->nullable()->after('term_start_date');
            $table->string('status_term')->default('Ongoing')->after('term_end_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purok_tbl', function (Blueprint $table) {
            //
              $table->dropColumn([
                'term_start_date',
                'term_end_date',
                'status_term'
            ]);
        });
    }
}
