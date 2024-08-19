<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_characteristics', function (Blueprint $table) {
            $table->id();
            $table->string('member_number')->unique();

            $table->string('name');
            $table->char('gender', 1);
            $table->string('identity_number', 16)->unique();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();

            $table->string('work')->nullable();
            $table->string('work_description')->nullable();
            $table->string('source_of_income')->nullable();

            $table->string('mother_name')->nullable();

            $table->integer('savings')->nullable();

            $table->integer('rice_consumption')->nullable();
            $table->integer('rice_price')->nullable();
            $table->integer('kitchen_shop')->nullable();
            $table->integer('electricity_bills')->nullable();
            $table->integer('education')->nullable();
            $table->integer('other_costs')->nullable();
            $table->integer('total_expenses')->nullable();

            $table->string('house_status')->nullable();
            $table->integer('yard_area')->nullable();
            $table->string('house_area')->nullable();
            $table->string('roof_type')->nullable();
            $table->string('house_wall')->nullable();
            $table->string('house_floor')->nullable();
            $table->string('type_of_lighting')->nullable();
            $table->string('latrine_type')->nullable();
            $table->string('source_of_drinking_water')->nullable();
            $table->integer('total_house_index')->nullable();

            $table->integer('total_household_income')->nullable();
            $table->integer('total_household_members')->nullable();
            $table->integer('income_per_capita')->nullable();

            $table->integer('tenor')->nullable();
            $table->integer('pokok')->nullable();
            $table->integer('margin')->nullable();
            $table->integer('installment')->nullable();
            $table->string('buyer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_characteristics');
    }
};
