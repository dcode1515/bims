<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('households_tbl', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('barangay_info_id');
            $table->string('reference_id')->unique();
            $table->string('status')->nullable();
            
            // Address Information
            $table->string('purok');
            $table->text('street');
            $table->string('household_number')->nullable();
        
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            
            // Household Information
            $table->enum('household_type', ['Single Family', 'Nuclear Family', 'Extended Family', 'Multi-generational'])->nullable();
            $table->enum('housing_type', ['Own', 'Rent', 'Rent free (w/ consent)', 'Others'])->nullable();
            $table->string('housing_type_other')->nullable();
            $table->enum('house_materials', ['Concrete', 'Wood', 'Mixed', 'Others'])->nullable();
            $table->string('house_materials_other')->nullable();
            $table->enum('water_source', ['None', 'ICWS', 'Well', 'Spring', 'Others'])->nullable();
            $table->string('water_source_icws')->nullable();
            $table->string('water_source_other')->nullable();
            $table->enum('power_supply', ['None', 'ILPI', 'Solar', 'Others'])->nullable();
            $table->string('power_supply_other')->nullable();
            $table->boolean('waste_biodegradable')->default(false);
            $table->boolean('waste_plastics')->default(false);
            $table->string('waste_others')->nullable();
            $table->enum('internet_provider', ['None', 'PLDT', 'Globe', 'Smart', 'Others'])->nullable();
            $table->string('internet_provider_other')->nullable();
            $table->enum('garbage_disposal', ['Garbage Collector', 'Burning', 'Composting', 'Others'])->nullable();
            $table->string('garbage_disposal_other')->nullable();
            
            // Fisherfolk Information
            $table->enum('fishing_vessel', ['None', 'Motorized', 'Non-Motorized'])->nullable();
            $table->decimal('avg_fish_catch', 10, 2)->nullable();
            $table->enum('fishing_frequency', ['Daily', 'Weekly', 'Monthly', 'Occasional'])->nullable();
            
            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('households_tbl');
    }
}
