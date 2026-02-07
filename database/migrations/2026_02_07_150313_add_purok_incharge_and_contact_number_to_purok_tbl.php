<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurokInchargeAndContactNumberToPurokTbl extends Migration
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
             $table->string('purok_incharge')->nullable()->after('id');
            $table->string('contact_number')->nullable()->after('purok_incharge');

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
             $table->dropColumn(['purok_incharge', 'contact_number']);
        });
    }
}
