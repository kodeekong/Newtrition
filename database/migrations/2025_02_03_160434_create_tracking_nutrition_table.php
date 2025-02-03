<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tracking_nutrition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['today', 'yesterday', 'last_week', 'custom'])->default('today');
            
            // Actual consumption data
            $table->float('calories_consumed')->nullable();
            $table->float('protein_consumed')->nullable();
            $table->float('carbs_consumed')->nullable();
            $table->float('fat_consumed')->nullable();
            $table->float('fiber_consumed')->nullable();
            $table->float('sodium_consumed')->nullable();
            $table->float('sugar_consumed')->nullable();

            // Goal data for each nutrient (for daily tracking, may vary based on long-term goals)
            $table->float('calories_goal')->nullable();
            $table->float('protein_goal')->nullable();
            $table->float('carbs_goal')->nullable();
            $table->float('fat_goal')->nullable();
            $table->float('fiber_goal')->nullable();
            $table->float('sodium_goal')->nullable();
            $table->float('sugar_goal')->nullable();

            // Optional: Additional columns for progress over time if needed
            $table->float('calories_remaining')->nullable();
            $table->float('protein_remaining')->nullable();
            $table->float('carbs_remaining')->nullable();
            $table->float('fat_remaining')->nullable();
            $table->float('fiber_remaining')->nullable();
            $table->float('sodium_remaining')->nullable();
            $table->float('sugar_remaining')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_nutrition');
    }
};
