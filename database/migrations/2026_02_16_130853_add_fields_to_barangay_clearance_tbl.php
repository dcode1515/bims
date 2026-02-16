<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBarangayClearanceTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangay_clearance_tbl', function (Blueprint $table) {
            //
              $table->string('name_requestor');
            $table->date('birthdate');
            $table->string('native')->nullable();
            $table->string('purok');

            // Character status stored as JSON
            $table->json('character_status')->nullable();

            $table->string('purpose');
            $table->date('date_issued');
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangay_clearance_tbl', function (Blueprint $table) {
            //
              $table->dropColumn([
                'name_requestor',
                'birthdate',
                'native',
                'purok',
                'character_status',
                'purpose',
                'date_issued',
                'status',
            ]);

        });
    }
}
