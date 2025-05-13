<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('food_entries', function (Blueprint $table) {
            // Only add meal_category if it doesn't exist
            if (!Schema::hasColumn('food_entries', 'meal_category')) {
                $table->enum('meal_category', ['breakfast', 'lunch', 'dinner', 'snack'])->default('snack');
            }
            // Remove the date column addition since it already exists
        });
    }

    public function down()
    {
        Schema::table('food_entries', function (Blueprint $table) {
            $table->dropColumn('meal_category');
            // Remove the date column drop since we didn't add it
        });
    }
}; 