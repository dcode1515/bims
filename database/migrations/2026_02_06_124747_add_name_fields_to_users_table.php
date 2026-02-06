<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('firstname')->after('id');
            $table->char('middle_initial', 1)->nullable()->after('firstname');
            $table->string('lastname')->after('middle_initial');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
              $table->dropColumn([
                'firstname',
                'middle_initial',
                'lastname',
            ]);
        });
    }
}
