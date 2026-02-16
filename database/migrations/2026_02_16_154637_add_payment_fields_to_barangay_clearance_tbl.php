<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToBarangayClearanceTbl extends Migration
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
              $table->string('payment_mode')->nullable()->after('date_issued');
            $table->date('date_paid')->nullable()->after('payment_mode');
            $table->decimal('amount', 10, 2)->nullable()->after('date_paid');
            $table->string('payment_status')->nullable()->after('amount');
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
                'payment_mode',
                'date_paid',
                'amount',
                'payment_status'
            ]);
        });
    }
}
