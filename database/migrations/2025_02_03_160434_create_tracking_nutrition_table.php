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

            $table->float('calories_consumed')->default(0);
            $table->float('protein_consumed')->default(0);
            $table->float('carbs_consumed')->default(0);
            $table->float('fat_consumed')->default(0);

            $table->float('calories_goal')->nullable();
            $table->float('protein_goal')->nullable();
            $table->float('carbs_goal')->nullable();
            $table->float('fat_goal')->nullable();


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
